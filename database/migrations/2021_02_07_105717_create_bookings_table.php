<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('nid')->nullable()->comment('หมายเลขผู้เสียภาษี 13 หลัก');
            $table->string('name')->comment('ชื่อผู้เสียภาษี');
            $table->char('type', 1)->nullable()->comment('ประเภทผู้เสียภาษี 0 = บุคคลธรรมดา, 1 = นิติบุลคล');
            $table->string('phone')->comment('โทรศัพท์');
            $table->string('email')->comment('อีเมล์');
            $table->string('facebook')->nullable()->comment('Facebook URL');
            $table->string('lineID')->nullable()->comment('LINE ID');
            $table->string('meeting_online')->nullable()->comment('URL ประชุม Online');
            $table->string('detail')->comment('รายละเอียดคำถาม');
            $table->date('date')->comment('วันที่นัดหมาย');
            $table->boolean('status')->default(0)->comment('0 = กำลังดำเนินการ 1 = เสร็จสิ้น');
            $table->unsignedBigInteger('employee_id')->nullable()->comment('เจ้าหน้าที่');
            $table->timestamps();

            $table->foreignId('appointment_id')->comment('การนัดหมาย')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('customer_option_id')->nullable()->comment('ประเภทผู้นัดหมายเพิ่มเติม')->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('subject_id')->nullable()->comment('หัวข้อนัดหมาย')->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('round_id')->nullable()->comment('รอบการนัดหมาย')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->comment('ผู้ใช้งาน')->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->foreign('employee_id')->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
