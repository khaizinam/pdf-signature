<?php

namespace Dev\Kernel\Commands;

use Dev\Base\Enums\BaseStatusEnum;
use Dev\ACL\Models\User;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use Dev\Base\Http\Controllers\BaseController;
use Dev\Base\Http\Responses\BaseHttpResponse;
use Dev\Member\Repositories\Interfaces\MemberInterface;
use Dev\Setting\Supports\SettingStore;
use Dev\Base\Facades\Assets;
use Dev\Media\Facades\AppMedia;

use Symfony\Component\HttpFoundation\Response;
use Carbon\CarbonInterface;
use Exception;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:test-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test laravel command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Ex: APPLICATION_ENV=development && php -d memory_limit=-1 artisan test:test
     *
     */
    public function handle()
    {
        $lspreadsheet = $lpusher = $loptions = false;
        $str = '{"result":{"statusCode":"200","message":"Success"},"targetUrl":null,"success":true,"error":null,"unAuthorizedRequest":false,"__abp":true}';
        $responseData = json_decode($str, TRUE);

        dd(
            ceil(round(1281.01)),
            ceil(1281.01),
            [
                ...Arr::get(
                    $responseData,
                    'result',
                    false
                ),
                "error" => false,
                "code" => Arr::get(
                    $responseData,
                    'result.statusCode',
                    false
                ),
                "data" => $responseData
            ],
            Arr::get(
                $responseData,
                'success',
                false
            ),
            Arr::get(
                $responseData,
                'result.statusCode',
                false
            )
        );
    }
}
