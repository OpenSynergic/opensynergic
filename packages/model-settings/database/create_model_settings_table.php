<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelSettingsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('model_settings')) {
            Schema::create('model_settings', function (Blueprint $table) {
                $table->string('model_type');
                $table->unsignedBigInteger('model_id');
                $table->string('locale')->nullable();
                $table->string('key')->index();
                $table->longtext('value')->nullable();
                $table->string('type')->default('string');

                $table->unique(['model_type', 'model_id', 'locale']);
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('model_settings');
    }
}
