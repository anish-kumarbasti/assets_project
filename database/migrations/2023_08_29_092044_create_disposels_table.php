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
        Schema::create('disposels', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('asset');
            $table->string('product_id')->nullable();
            $table->integer('period_months');
            $table->decimal('asset_value', 10, 2);
            $table->string('desposal_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposels');
    }
};
