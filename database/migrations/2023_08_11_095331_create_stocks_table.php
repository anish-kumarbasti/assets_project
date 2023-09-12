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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('product_info');
            $table->unsignedBigInteger('asset_type_id');
            $table->unsignedBigInteger('asset');
            $table->unsignedBigInteger('brand_id')->default(0);
            $table->unsignedBigInteger('brand_model_id')->default(0);
            $table->unsignedBigInteger('location_id')->nullable();
            $table->unsignedBigInteger('sublocation_id')->default(0);
            $table->text('configuration')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('vendor')->nullable();
            $table->string('price');
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
