<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->unsignedBigInteger('faculty_id')->nullable();
            $table->foreign('faculty_id', 'faculty_fk_7578960')->references('id')->on('faculties');
            $table->unsignedBigInteger('program_id')->nullable();
            $table->foreign('program_id', 'program_fk_7578961')->references('id')->on('programs');
            $table->unsignedBigInteger('convocation_id')->nullable();
            $table->foreign('convocation_id', 'convocation_fk_7578962')->references('id')->on('convocations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            //
        });
    }
};
