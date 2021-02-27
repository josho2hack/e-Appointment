<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name')->comment('การนัดหมาย');
            $table->boolean('pit')->default(1)->comment('บุคคลธรรมดา');
            $table->boolean('cit')->default(1)->comment('นิติบุลคล');
            $table->integer('worker')->comment('จำนวนเจ้าหน้าที่');
            $table->boolean('official')->default(1)->comment('ข้าราชการ');
            $table->boolean('employee')->default(0)->comment('ลูกจ้าง,พนักงานราชการ');
            $table->boolean('mon')->default(1)->comment('จันทร์');
            $table->boolean('tue')->default(1)->comment('อังคาร');
            $table->boolean('wed')->default(1)->comment('พุธ');
            $table->boolean('thu')->default(1)->comment('พฤหัสบดี');
            $table->boolean('fri')->default(1)->comment('ศุกร์');
            $table->boolean('public')->default(0)->comment('เปิดใช้งาน');
            $table->unsignedBigInteger('public_user_id')->nullable()->comment('ผู้เปิดใช้งาน');
            $table->timestamps();

            $table->foreignId('office_id')->comment('หน่วยงาน')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->comment('ผู้บันทึกการนัดหมาย')->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->foreign('public_user_id')->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
