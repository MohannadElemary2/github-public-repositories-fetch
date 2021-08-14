<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepositoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repositories', function (Blueprint $table) {
            $table->id();
            $table->integer('external_id');
            $table->string('name');
            $table->string('full_name');
            $table->string('language')->nullable();
            $table->string('owner_name');
            $table->string('owner_image');
            $table->integer('stars');
            $table->date('created')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('stars');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repositories');
    }
}
