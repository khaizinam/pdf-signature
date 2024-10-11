<?php

namespace Dev\Kernel\Commands;

use Dev\Lead\Models\Lead;
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
use Illuminate\Support\Facades\Schema;

use Dev\Base\Http\Controllers\BaseController;
use Dev\Base\Http\Responses\BaseHttpResponse;
use Dev\Member\Repositories\Interfaces\MemberInterface;
use Dev\Setting\Supports\SettingStore;
use Dev\Google\Http\Resources\v1\SpreadsheetResource;
use Dev\Lead\Repositories\Interfaces\AppInterface;
use Dev\Lead\Repositories\Interfaces\ConnectionInterface;
use Dev\SocialAuth\Services\SocialAuthService;
use Dev\SocialLogin\Facades\SocialService;
use Dev\Base\Facades\Assets;
use Dev\Media\Facades\AppMedia;
use Dev\Category\Models\Product;
use Dev\Category\Repositories\Interfaces\ProductInterface;

use Symfony\Component\HttpFoundation\Response;
use Carbon\CarbonInterface;
use Revolution\Google\Sheets\Sheets;
use Exception;
use Throwable;

class MssqlCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "cms:mssql-migration:test";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Test laravel command";

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
        $tables = DB::connection("sqlsrv")->getDoctrineSchemaManager()->listTableNames();

        #region sync nhóm Tb_LoaiDV
        Schema::disableForeignKeyConstraints();
        DB::connection("sqlsrv")->table("Tb_LoaiDV")->select([
            "*"
        ])->get()->each(function ($serviceType) {
            // dd((array)$serviceTypes);
        });
        Schema::enableForeignKeyConstraints();
        #endregion

        #region sync nhóm LOAIDICHVU (tại sao lại có thêm Tb_LoaiDV)
        Schema::disableForeignKeyConstraints();
        DB::connection("sqlsrv")->table("LOAIDICHVU")->select([
            "*"
        ])->get()->each(function ($serviceType) {
            // dd((array)$serviceTypes);
        });
        Schema::enableForeignKeyConstraints();
        #endregion

        #region sync nhóm Phong_Ban
        Schema::disableForeignKeyConstraints();
        DB::connection("sqlsrv")->table("Phong_Ban")->select([
            "*"
        ])->get()->each(function ($department) {
            // dd((array)$department);
        });
        Schema::enableForeignKeyConstraints();
        #endregion

        #region sync nhóm sản phẩm
        Schema::disableForeignKeyConstraints();
        DB::connection("sqlsrv")->table("Nhom_Sp")->select([
            "*"
        ])->get()->each(function ($product_category) {
            dd((array)$product_category);
        });
        Schema::enableForeignKeyConstraints();
        #endregion

        #region sync sản phẩm
        Schema::disableForeignKeyConstraints();
        DB::connection("sqlsrv")->table("San_Pham")->select([
            "MaSp AS product_code",
            "TenSp AS product_name",
            "DonVT AS unit",
            "Mota AS description",
            "Dongia AS price",
            "Gianhap AS import_price"
        ])->get()->each(function ($product) {
            // app(ProductInterface::class)->create((array)$product);
            dd((array)$product);
        });
        Schema::enableForeignKeyConstraints();
        #endregion
    }
}
