<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iwebhooks__hook_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your translatable fields
            $table->text('title');
            $table->text('description');
            $table->text('action_label')->nullable();
            $table->integer('hook_id')->unsigned();
            $table->string('locale')->index();
            $table->unique(['hook_id', 'locale']);
            $table->foreign('hook_id')->references('id')->on('iwebhooks__hooks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('iwebhooks__hook_translations', function (Blueprint $table) {
            $table->dropForeign(['hook_id']);
        });
        Schema::dropIfExists('iwebhooks__hook_translations');
    }
};
