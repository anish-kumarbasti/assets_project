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
        Schema::table('notifications', function (Blueprint $table) {
            $table->unsignedBigInteger('issuance_id')->nullable();
            $table->unsignedBigInteger('transfer_id')->nullable();
            $table->unsignedBigInteger('return_id')->nullable();
            $table->foreign('issuance_id')->references('id')->on('issuences')->onUpdate('set null');
            $table->foreign('transfer_id')->references('id')->on('transfers')->onUpdate('set null');
            $table->foreign('return_id')->references('id')->on('asset_returns')->onUpdate('set null');
        });

    }

    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            //
        });
    }
};
