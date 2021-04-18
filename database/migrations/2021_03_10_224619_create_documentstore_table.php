<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentstoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentstore', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('slug', 50);
            $table->unsignedInteger('user_admin');
            $table->json('objstore');
            $table->json('secobjstore')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documentstore');
    }
}
