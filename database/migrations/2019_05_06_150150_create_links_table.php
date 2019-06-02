<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('url');
            $table->boolean('private')->default(false);
            $table->text('domain')->nullable();
            $table->string('title')->nullable();
            $table->string('type')->default('redirect'); //redirect,page,iframe
            $table->bigInteger('user_id')->nullable();
            $table->string('code')->unique()->nullable();
            $table->string('password')->nullable();
            $table->longText('body')->nullable();
            $table->longText('data')->nullable();
            $table->ipAddress('ip');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('links');
    }
}
