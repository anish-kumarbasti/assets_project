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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->comment('This Id is come from User table.');
            $table->string('product_id')->comment('This id is come from Product_id field of Issuence Table.');
            $table->unsignedBigInteger('reason_id')->comment('This is come from Transfer_reason table.');
            $table->string('handover_employee_id')->comment('This Id belongs to the Employee whom we are transferring.');
            $table->text('description');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
