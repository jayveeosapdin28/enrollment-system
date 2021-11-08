<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStudentTypeToAdditionalInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('additional_information', function (Blueprint $table) {
            if(!Schema::hasColumn('additional_information', 'student_type'))
            {
                $table->string('student_type')->after('tribe');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('additional_information', function (Blueprint $table) {
            //
        });
    }
}
