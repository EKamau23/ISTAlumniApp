<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{       
    public function up(): void
    {
        Schema::create('ist_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('job_name');
            $table->string('job_title');
            $table->text('job_description');
            $table->text('job_qualification');
            $table->string('job_location');
            $table->decimal('job_amount', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('ist_jobs');
    }
};
