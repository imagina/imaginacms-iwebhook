<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIwebhooksLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iwebhooks__logs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields...
            $table->integer('hook_id')->unsigned();
            $table->string('http_status');
            $table->text('response');
            $table->foreign('hook_id')->references('id')->on('iwebhooks__hooks')->onDelete('cascade');
            // Audit fields
            $table->timestamps();
            $table->auditStamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('iwebhooks__logs', function (Blueprint $table) {
        $table->dropForeign(['hook_id']); // Drop foreign key constraint
      });
        Schema::dropIfExists('iwebhooks__logs');
    }
}
