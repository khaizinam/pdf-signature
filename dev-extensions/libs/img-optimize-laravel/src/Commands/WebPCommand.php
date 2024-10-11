<?php

namespace Dev\ImgOptimize\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

use NotificationChannels\Telegram\TelegramMessage;
use NotificationChannels\Telegram\TelegramChannel;

use Dev\Base\Facades\BaseHelper;
use Dev\Base\Http\Controllers\BaseController;
use Dev\Media\Facades\AppMedia;
use Dev\Media\Http\Resources\FileResource;
use Dev\Media\Http\Resources\FolderResource;
use Dev\Media\Models\MediaFile;
use Dev\Media\Models\MediaFolder;
use Dev\Media\Models\MediaSetting;
use Dev\Media\Repositories\Interfaces\MediaFileInterface;
use Dev\Media\Repositories\Interfaces\MediaFolderInterface;
use Dev\Media\Services\ThumbnailService;
use Dev\Media\Services\UploadsManager;
use Dev\Media\Supports\Zipper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Exception;
use Throwable;
use Laravel\Socialite\Facades\Socialite;
use Dev\SocialLogin\Facades\SocialService;
use Carbon\Carbon;
use Carbon\CarbonInterface;

use function Laravel\Prompts\{progress, table};

use Symfony\Component\Console\Attribute\AsCommand;

class WebPCommand extends Command
{
    private $logger = 'imgoptimize'; // logger filename
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate webp file & thumbnails, sudo yum install libwebp-tools jpegoptim optipng pngquant gifsicle libavif-bin';

    /**
     * The name and signature of the console command.
     * php artisan cms:media:imgoptize:webp --help
     * php artisan cms:media:imgoptize:webp
     *
     * @var string
     */
    protected $signature = 'cms:media:imgoptize:webp';


    public function __construct(
        protected MediaFileInterface $fileRepository,
        protected MediaFolderInterface $folderRepository,
        protected UploadsManager $uploadManager,
        protected ThumbnailService $thumbnailService
    ) {
        parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @throws Throwable
     */
    public function handle()
    {
        try {
            $this->info("ImgOptimize handle =======================================================================");
            Log::channel($this->logger)->info("ImgOptimize handle =======================================================================");

            $this->components->info('Starting to generate thumbnails...');

            if (function_exists('exec')) {
                $folderId = 1;
                $paramsFolder = [];
                $paramsFile = [];

                $queried = $this->fileRepository->all(); // $queried = $this->fileRepository->getFilesByFolderId($folderId, $paramsFile, true, $paramsFolder);
                $folders = FolderResource::collection($queried->where('is_folder', 1));
                $files = FileResource::collection($queried->where('is_folder', 0));

                $progress = progress(
                    label: sprintf('Processing %s %s...', number_format($files->count()), Str::plural('file', $files->count())),
                    steps: $files->count(),
                );
                $errors = [];
                foreach ($files as $key => $file) {
                    /**
                     * @var MediaFile $file
                     */
                    $file = $file->resource;
                    $_tmpFile = $file->replicateQuietly();

                    if (!$file || !$file->canGenerateThumbnails()) {
                        continue;
                    }

                    try {
                        $progress->label(sprintf('Processing %s...', $file->url));

                        $folderPath = File::dirname($_tmpFile->url);
                        $newFilePath = $folderPath . '/' . File::name($_tmpFile->url) . '.webp';
                        $newRealFilePath = AppMedia::getRealPath($newFilePath);

                        $oriRealFilePath = AppMedia::getRealPath($_tmpFile->url);

                        if (File::exists($oriRealFilePath)) {
                            $_tmpFile->url = $newFilePath; // fake
                            $_tmpFile->mime_type = "image/webp"; // fake
                        }

                        $shekztech_command = "cwebp -q 75 -mt {$oriRealFilePath} -o {$newRealFilePath}";
                        exec($shekztech_command);

                        foreach (AppMedia::getSizes() as $size) {
                            $readableSize = explode('x', $size);

                            $thumbnailPath = File::name($file->url) . '-' . $size . '.' . File::extension($file->url);
                            $this->thumbnailService
                                ->setImage($newRealFilePath)
                                ->setSize($readableSize[0], $readableSize[1])
                                ->setDestinationPath(File::dirname($_tmpFile->url))
                                ->setFileName($thumbnailPath)
                                ->save();
                        }

                        if (File::exists($newRealFilePath)) {
                            $file->url_optimized = $newFilePath;
                            $file->mime_type_optimized = "image/webp";

                            $file->save();
                        }

                        $progress->advance();
                    } catch (Throwable $th) {
                        $errors[] = $file->url;
                        $this->components->error($th->getMessage());
                    }
                }
                $progress->finish();
                $this->components->info('Generated media thumbnails successfully!');
                $errors = array_unique($errors);
                $errors = array_map(fn($item) => [$item], $errors);

                if ($errors) {
                    $this->components->info('We are unable to regenerate thumbnail for these files:');

                    table(['File directory'], $errors);

                    return self::FAILURE;
                }

                return self::SUCCESS;
            } else {
                $this->error("exec is disabled");
                Log::channel($this->logger)->info("exec is disabled");
            }

        } catch (Throwable $th) {
            $this->info($th);
            Log::channel($this->logger)->error($th->getMessage());
        }
    }
}
