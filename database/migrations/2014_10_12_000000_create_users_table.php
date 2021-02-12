<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('pin')->unique()->nullable()->comment('หมายเลขบัตรประชาชน/หนังสือเดินทาง');
            $table->string('title')->nullable()->comment('คำนำหน้าชื่อ');
            $table->string('first_name')->comment('ชื่อ');
            $table->string('last_name')->comment('นามสกุล');
            $table->char('sex', 1)->nullable()->comment('เพศ');
            $table->date('date_of_birth')->nullable()->comment('วันเกิด');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->nullable()->comment('โทรศัพท์');
            $table->string('facebook')->nullable()->comment('Facebook URL');
            $table->string('line_id')->nullable()->comment('LINE ID');
            $table->string('provider_id')->nullable();
            $table->string('avatar')->nullable();
            $table->string('password')->nullable()->comment('รหัสผ่าน');
            $table->string('notification_preference')->default('mail, database')->comment('การแจ้งเตือน');
            $table->string('lsk')->unique()->nullable()->comment('ลสก.');
            $table->string('uid')->unique()->nullable()->comment('รหัส e-Office');
            $table->string('position')->nullable()->comment('ตำแหน่ง');
            $table->string('class')->nullable()->comment('ระดับ');
            $table->string('position_action')->nullable()->comment('หน้าที่');
            $table->string('groupname')->nullable()->comment('กลุ่ม/ฝ่าย/แผนก');
            $table->string('level')->nullable()->comment('ระดับในโครงสร้าง 1=ผอ., 2=ชช., 3=หัวหน้า, 4=เจ้าหน้าที่');
            $table->string('employee_type')->nullable()->comment('ประเภทเจ้าหน้าที่ 0=หน่วยงานอื่น, 1=ข้าราชการ, 2=ลูกจ้างประจำ, 3=พนักงานราชการ, 7=ลูกจ้างชั่วคราว');
            $table->rememberToken();
            $table->timestamps();

            $table->foreignId('role_id')->nullable()->comment('สิทธิ์การใช้งาน')->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('office_id')->nullable()->comment('หน่วยงาน')->constrained()->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
