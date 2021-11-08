<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProspectusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prospectuses', function (Blueprint $table) {
            $table->id();
            $table->string('proscode');
            $table->string('prosdesc');
            $table->foreignId('corid')
                ->nullable()
                ->constrained('courses')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('cureffec');
            $table->string('currcmo');
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
        Schema::dropIfExists('prospectuses');
    }
}
