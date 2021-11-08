<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrolledSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrolled_subjects', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->foreignId('enrollment_application_id')
                ->nullable()
                ->constrained('enrollment_applications')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('subjects_id')
                ->nullable()
                ->constrained('subjects')
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
        Schema::dropIfExists('enrolled_subjects');
    }
}
