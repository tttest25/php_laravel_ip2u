<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('signpath', 200);        // path for stored signs
            $table->json('signobj');                // object for store sign json
            $table->unsignedBigInteger('files_id'); // foreign key for files_id


            $table->foreign('files_id')
                ->references('id')
                ->on('files')
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('signs');
    }
}
