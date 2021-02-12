<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_options', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('ประเภทผู้นัดหมายเพิ่มเติม');
            $table->boolean('require_pin')->default(0)->comment('ต้องการหมายเลขบัตรประชาชนหรือหนังสือเดินทาง');
            $table->timestamps();

            $table->foreignId('appointment_id')->comment('การนัดหมาย')->constrained()->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_options');
    }
}
