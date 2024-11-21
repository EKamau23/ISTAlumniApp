<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('applied_job', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('job_id')->constrained('ist_jobs')->onDelete('cascade');
            $table->string('name');
            $table->text('user_info');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('applied_jobs');
    }
};
