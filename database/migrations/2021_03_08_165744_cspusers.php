<?php



/* table for crypto pro */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
mysql> describe cspusers;
+--------------+--------------+------+-----+---------+----------------+
| Field        | Type         | Null | Key | Default | Extra          |
+--------------+--------------+------+-----+---------+----------------+
| cid          | int          | NO   | PRI | NULL    | auto_increment |
| userid       | int          | YES  |     | NULL    |                |
| serialNumber | varchar(100) | NO   |     | NULL    |                |
+--------------+--------------+------+-----+---------+----------------+
3 rows in set (0.01 sec)
*/

class Cspusers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('cspusers', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('userid');
            $table->string('serialNumber', 100);
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
        //
        Schema::dropIfExists('cspusers');
    }
}
