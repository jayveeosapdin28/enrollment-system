<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGuardianAddressToFamilyInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('family_information', function (Blueprint $table) {
            if(!Schema::hasColumn('family_information', 'guardian_country'))
            {
                $table->string('guardian_country')->after('phone2');
            }
            if(!Schema::hasColumn('family_information', 'guardian_barangay'))
            {
                $table->foreignId('guardian_barangay')
                    ->nullable()
                    ->constrained('barangays')
                    ->onUpdate('cascade')
                    ->onDelete('cascade')
                    ->after('phone2');
            }
            if(!Schema::hasColumn('family_information', 'guardian_city'))
            {
                $table->foreignId('guardian_city')
                    ->nullable()
                    ->constrained('cities')
                    ->onUpdate('cascade')
                    ->onDelete('cascade')
                    ->after('phone2');
            }
            if(!Schema::hasColumn('family_information', 'guardian_province'))
            {
                $table->foreignId('guardian_province')
                    ->nullable()
                    ->constrained('provinces')
                    ->onUpdate('cascade')
                    ->onDelete('cascade')
                    ->after('phone2');
            }
            if(!Schema::hasColumn('family_information', 'guardian_street'))
            {
                $table->string('guardian_street')->after('phone2')->nullable();
            }
            if(!Schema::hasColumn('family_information', 'guardian_house'))
            {
                $table->string('guardian_house')->after('phone2')->nullable();
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
        Schema::table('family_information', function (Blueprint $table) {

        });
    }
}
