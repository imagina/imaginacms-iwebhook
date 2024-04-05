<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIwebhooksLogTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iwebhooks__log_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields

            $table->integer('log_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['log_id', 'locale']);
            $table->foreign('log_id')->references('id')->on('iwebhooks__logs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iwebhooks__log_translations', function (Blueprint $table) {
            $table->dropForeign(['log_id']);
        });
        Schema::dropIfExists('iwebhooks__log_translations');
    }
}
