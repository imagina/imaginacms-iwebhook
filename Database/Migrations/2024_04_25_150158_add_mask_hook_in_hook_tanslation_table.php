<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMaskHookInHookTanslationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('iwebhooks__hook_translations', function (Blueprint $table) {
          $table->text('mask_hook')->nullable()->after('title');
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
          $table->dropColumn('mask_hook');
        });
    }
}
