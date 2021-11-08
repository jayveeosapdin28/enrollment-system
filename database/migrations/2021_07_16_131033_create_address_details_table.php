<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('brthhouseno')->nullable();
            $table->string('brthstreet')->nullable();
            $table->foreignId('brthbrgy')
                ->nullable()
                ->constrained('barangays')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('brthtown')
                ->nullable()
                ->constrained('cities')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('brthprovince')
                ->nullable()
                ->constrained('provinces')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('brthcountry');


            $table->integer('addhouseno')->nullable();
            $table->string('addstreet')->nullable();
            $table->foreignId('addbrgy')
                ->nullable()
                ->constrained('barangays')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('addtown')
                ->nullable()
                ->constrained('cities')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('addprovince')
                ->nullable()
                ->constrained('provinces')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('addcountry');
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
        Schema::dropIfExists('address_details');
    }
}
