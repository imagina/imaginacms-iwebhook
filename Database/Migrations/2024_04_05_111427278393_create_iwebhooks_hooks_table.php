<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIwebhooksHooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iwebhooks__hooks', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            // Your fields...
            $table->text('endpoint');
            $table->text('http_method')->default('POST');
            $table->json('body')->nullable();
            $table->json('headers')->nullable();
            $table->boolean('is_loading')->default(0)->nullable();
            $table->integer('call_every_minutes')->nullable();
            $table->text('redirect_link')->nullable();
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('iwebhooks__categories')->onDelete('cascade');

            $table->integer('country_id')->unsigned()->nullable();
            $table->foreign('country_id')->references('id')->on('ilocations__countries')->onDelete('cascade');
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
        Schema::dropIfExists('iwebhooks__hooks');
    }
}
