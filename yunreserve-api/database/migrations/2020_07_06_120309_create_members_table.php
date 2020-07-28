<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('member_name', 10);
            $table->string('member_account', 15);
            $table->string('member_password', 15);
            $table->string('member_email', 64);
            $table->string('member_phone', 10);
            $table->string('member_bankCode', 3);
            $table->string('member_bankAccount', 20);
            $table->string('verify',1);
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
        Schema::dropIfExists('members');
    }
}
