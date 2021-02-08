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
            $table->string('name')->comment('การนัดหมาย');
            $table->boolean('PIT')->default(0)->comment('บุคคลธรรมดา');
            $table->boolean('CIT')->default(0)->comment('นิติบุลคล');
            $table->tinyInteger('employee')->comment('จำนวนเจ้าหน้าที่');
            $table->boolean('mon')->default(0)->comment('จันทร์');
            $table->boolean('tue')->default(0)->comment('อังคาร');
            $table->boolean('wed')->default(0)->comment('พุธ');
            $table->boolean('thu')->default(0)->comment('พฤหัสบดี');
            $table->boolean('fri')->default(0)->comment('ศุกร์');
            $table->boolean('public')->default(0)->comment('เปิดใช้งาน');
            $table->timestamps();

            $table->foreignId('office_id')->comment('หน่วยงาน')->constrained()->onUpdate('cascade')->onDelete('cascade');
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
