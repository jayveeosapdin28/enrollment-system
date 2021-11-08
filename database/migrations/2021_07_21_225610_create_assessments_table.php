<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_application_id')
                ->nullable()
                ->constrained('enrollment_applications')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('asstransno')->nullable();
            $table->foreignId('feeid')
                ->nullable()
                ->constrained('fees')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('feemode')->nullable();
            $table->string('feename')->nullable();
            $table->string('feeamount1')->nullable();
            $table->string('feeclass')->nullable();
            $table->string('asscat')->nullable();
            $table->string('ornumber')->nullable();
            $table->string('datapayment')->nullable();
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
        Schema::dropIfExists('assessments');
    }
}
