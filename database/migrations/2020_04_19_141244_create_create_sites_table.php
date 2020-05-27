<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('create_sites', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('domain');
            $table->string('name');
            $table->string('description');
            $table->string('logo');
            $table->string('bg');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('create_sites');
    }
}
