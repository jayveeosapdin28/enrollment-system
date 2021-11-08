<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrollmentApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrollment_applications', function (Blueprint $table) {
            $table->id();
            $table->string('idnumber',50)->nullable();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('corid')
                ->nullable()
                ->constrained('courses')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('yearlevel',50);
            $table->string('campcode',50);
            $table->string('cureffec',50);
            $table->string('studsem',50);
            $table->string('studsection',50)->nullable();
            $table->string('status',50)->nullable();
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
        Schema::dropIfExists('enrollment_applications');
    }
}
