<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamilyInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('fathnam3',50);
            $table->string('fathnam2',50);
            $table->string('fathnam1',50);
            $table->string('fathnam4',5)->nullable();
            $table->string('fathoccup',50);
            $table->string('mothnam3',50);
            $table->string('mothnam2',50);
            $table->string('mothnam1',50);
            $table->string('mothoccup',50);
            $table->string('guardian',50);
            $table->string('relationship',50);
            $table->string('phone2',15);
            $table->string('annualfamincome',255);
            $table->string('parentstatus',255);
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
        Schema::dropIfExists('family_information');
    }
}
