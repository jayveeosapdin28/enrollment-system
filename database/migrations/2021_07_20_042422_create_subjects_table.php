<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('subcode');
            $table->string('subdesc');
            $table->foreignId('prospectus_id')
                ->nullable()
                ->constrained('prospectuses')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('subsem');
            $table->string('subyear');
            $table->string('subunit');
            $table->string('sublechours')->nullable();
            $table->string('sublabhours')->nullable();
            $table->string('sublabequip')->nullable();
            $table->string('subweekhours')->nullable();
            $table->string('subprerequisite')->nullable();
            $table->string('subfee')->nullable();
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
        Schema::dropIfExists('subjects');
    }
}
