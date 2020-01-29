<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GuestRegistration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guest_registration', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedInteger('personal_id')->unique();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email_address', 100); //varchar(100) not null
            $table->char('brand', 1); //varchar(1) (Royal = R, Celebrity = C, Azamara = Z)
            $table->boolean('email_list_flag'); // number not null (0 or 1)
            $table->string('ship', 100); // ship varchar(100) nut null
            $table->date('sail_date'); // date not null
            $table->string('comments', 500); //comments varchar(500)
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
    }
}
