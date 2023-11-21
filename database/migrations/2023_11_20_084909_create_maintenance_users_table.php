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
        Schema::create('maintenance_users', function (Blueprint $table) {
            $table->id();
            $table->string('product_id');
            $table->string('maintenance_reason');
            $table->text('description');
            $table->unsignedBigInteger('perform_by_user');
            $table->string('transaction_code');
            $table->unsignedBigInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_users');
    }
};
