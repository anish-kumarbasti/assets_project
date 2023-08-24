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
        Schema::create('issuences', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id');
            $table->string('asset_type_id');
            $table->string('asset_id');
            $table->string('product_id');
            $table->text('description');
            $table->timestamp('issuing_time_date');
            $table->string('due_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issuences');
    }
};
