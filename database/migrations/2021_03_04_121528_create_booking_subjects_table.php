<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_subject', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->comment('จองนัดหมาย')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('subject_id')->comment('หัวข้อนัดหมาย')->constrained()->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('booking_subject');
    }
}
