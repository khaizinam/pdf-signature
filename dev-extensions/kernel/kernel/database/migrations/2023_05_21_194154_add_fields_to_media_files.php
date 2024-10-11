<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Dev\Base\Supports\Database\Blueprint;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        if (Schema::hasTable('media_files')) {
            Schema::table('media_files', function (Blueprint $table) {
                $foreignKeys = $this->listTableForeignKeys('media_files');
                dump($foreignKeys);

                $indexes = $this->listTableIndexes('media_files');
                dump($indexes);
                // if (in_array('plans_slug_unique', $indexes)) $table->dropIndex('plans_slug_unique');

                if (!Schema::hasColumn('media_files', 'visibility')) {
                    $table->char('visibility', 191)->nullable(true);
                }              
            });
        }
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }

    public function listTableForeignKeys($table)
    {
        $conn = Schema::getConnection()->getDoctrineSchemaManager();

        return array_map(function ($key) {
            return $key->getName();
        }, $conn->listTableForeignKeys($table));
    }

    public function listTableIndexes($table)
    {
        $conn = Schema::getConnection()->getDoctrineSchemaManager();

        return array_map(function ($key) {
            return $key->getName();
        }, $conn->listTableIndexes($table));
    }
};
