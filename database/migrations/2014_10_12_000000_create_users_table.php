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
            $table->string('PIN')->nullable()->comment('หมายเลขบัตรประชาชน/หนังสือเดินทาง');
            $table->string('first_name')->comment('ชื่อ');
            $table->string('last_name')->comment('นามสกุล');
            $table->char('sex', 1)->nullable()->comment('เพศ');
            $table->date('date_of_birth')->nullable()->comment('วันเกิด');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->nullable()->comment('โทรศัพท์');
            $table->string('facebook')->nullable()->comment('Facebook URL');
            $table->string('lineID')->nullable()->comment('LINE ID');
            $table->string('provider_id')->nullable();
            $table->string('avatar')->nullable();
            $table->string('password')->nullable()->comment('รหัสผ่าน');
            $table->string('notification_preference')->default('mail, database');
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
