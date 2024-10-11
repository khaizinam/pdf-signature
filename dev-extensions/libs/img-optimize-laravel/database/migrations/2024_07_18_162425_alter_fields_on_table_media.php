<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('media_files', function (Blueprint $table) {
            if (!Schema::hasColumn('media_files', 'url_optimized')) {
                $table->string('url_optimized', 255)->after('url')->nullable();
            }
            if (!Schema::hasColumn('media_files', 'mime_type_optimized')) {
                $table->string('mime_type_optimized', 120)->after('mime_type')->nullable();
            }
        });
        #endregion drop
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('media_files', function (Blueprint $table) {
            //
        });
    }
};
