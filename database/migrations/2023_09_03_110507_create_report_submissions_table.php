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
    Schema::create('report_submissions', function (Blueprint $table) {
        $table->id();
        $table->string('new_field', 255);
        $table->date('startDate');
        $table->date('targetDate');
        $table->string('location', 255);
        $table->string('materials', 255);
        $table->string('personnel', 255);
        $table->unsignedBigInteger('report_id');
        $table->text('actions_taken');
        $table->string('remarks', 255);
        $table->timestamps();
        $table->string('photo', 300);
        $table->foreign('report_id')->references('id')->on('reports')->onUpdate('cascade')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_submissions');
    }
};
