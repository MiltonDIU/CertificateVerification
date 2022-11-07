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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('serial_no')->unique();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('student_id_no')->unique();
            $table->string('cgpa');
            $table->string('out_of_cgpa');
            $table->string('certificate_generate_day_month');
            $table->string('certificate_generate_year');
            $table->string('result_published_date');
            $table->string('faculty_name');
            $table->string('program_name');
            $table->string('convocation_name');
            $table->string('hash_code');
            $table->string('certificate_url');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
};
