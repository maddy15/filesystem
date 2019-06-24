<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('identifier')->unique();
            $table->bigInteger('user_id')->unsigned()->index();
            $table->string('title');
            $table->string('overview_short',300);
            $table->string('overview');
            $table->decimal('price',6,2);
            $table->boolean('live')->default(0);
            $table->boolean('approved')->default(0);
            $table->boolean('finished')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
