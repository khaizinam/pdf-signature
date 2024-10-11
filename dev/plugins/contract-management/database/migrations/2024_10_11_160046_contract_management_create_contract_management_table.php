<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('contract_managements')) {
            Schema::create('contract_managements', function (Blueprint $table) {
                $table->id();
                $table->string('name', 255);
                $table->string('status', 60)->default('published');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('contract_managements_translations')) {
            Schema::create('contract_managements_translations', function (Blueprint $table) {
                $table->string('lang_code');
                $table->foreignId('contract_managements_id');
                $table->string('name', 255)->nullable();

                $table->primary(['lang_code', 'contract_managements_id'], 'contract_managements_translations_primary');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_managements');
        Schema::dropIfExists('contract_managements_translations');
    }
};
