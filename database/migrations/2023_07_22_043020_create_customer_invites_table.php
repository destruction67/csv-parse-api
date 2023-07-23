<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_invites', function (Blueprint $table) {
            $table->increments('id');
            $table->string('trans_type');
            $table->date('trans_date');
            $table->time('trans_time');
            $table->integer('cust_num');
            $table->string('cust_fname');
            $table->string('cust_email')->nullable();
            $table->string('cust_phone')->nullable();
            $table->string('description')->nullable();
            $table->boolean('isSent')->nullable();
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
        Schema::dropIfExists('customer_invites');
    }
}
