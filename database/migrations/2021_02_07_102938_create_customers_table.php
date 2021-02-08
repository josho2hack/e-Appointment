<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('nid')->unique()->comment('หมายเลขผู้เสียภาษี 13 หลัก');
            $table->string('name')->comment('ชื่อผู้เสียภาษี');
            $table->char('type', 1)->comment('ประเภทผู้เสียภาษี 0 = บุคคลธรรมดา, 1 = นิติบุลคล');
            $table->timestamps();

            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
