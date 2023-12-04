<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('update_report_submissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('report_submission_id');
            $table->text('actions_taken');
            $table->string('remarks', 255);
            $table->string('photo', 300);
            $table->timestamps();
            $table->foreign('report_submission_id')->references('id')->on('report_submissions')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('update_report_submissions');
    }
};
