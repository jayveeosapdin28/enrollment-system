<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentPersonalInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_personal_infos', function (Blueprint $table) {
            $table->id();
            $table->string('studnam3',30);
            $table->string('studnam2',30)->nullable();
            $table->string('studnam1',30);
            $table->string('studnam4',5)->nullable();
            $table->string('gender');
            $table->date('studbday');
            $table->string('studcivilstat');
            $table->string('nationality',30);
            $table->foreignId('religion_id')
                ->nullable()
                ->constrained('religions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('student_personal_infos');
    }
}
