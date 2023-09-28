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
        Schema::create('timelines', function (Blueprint $table) {
            $table->id();
            $table->string('action');
            $table->unsignedBigInteger('user_id')->nullable()->comment('Id from User Table');
            $table->unsignedBigInteger('product_id')->nullable()->comment('Id from Stock Table');
            $table->unsignedBigInteger('asset_type_id')->nullable()->comment('Id from AssetType Table');
            $table->unsignedBigInteger('asset_id')->nullable()->comment('Id from Asset Table');
            $table->unsignedBigInteger('issuance_id')->nullable()->comment('Id from Issuance Table');
            $table->unsignedBigInteger('issuance_by')->nullable()->comment('Id from Issuing person which is come from User Table');
            $table->unsignedBigInteger('transfer_id')->nullable()->comment('Id from Transfer Table');
            $table->unsignedBigInteger('transfer_by')->nullable()->comment('Id from Transferring person which is come from User Table');
            $table->unsignedBigInteger('disposal_id')->nullable()->comment('Id from Disposal Table');
            $table->unsignedBigInteger('disposal_by')->nullable()->comment('Id from Disposing person which is come from User Table');
            $table->unsignedBigInteger('maintenance_id')->nullable()->comment('Id from Maintenance Table');
            $table->unsignedBigInteger('maintenance_by')->nullable()->comment('Id from Maintaining person which is come from Supplier Table');
            $table->unsignedBigInteger('return_id')->nullable()->comment('Id from Return Table');
            $table->unsignedBigInteger('return_by')->nullable()->comment('Id from Returning person which is come from User Table');
            $table->softDeletes();
            $table->timestamps();
        
            // Define foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('product_id')->references('id')->on('stocks')->onDelete('set null');
            $table->foreign('asset_type_id')->references('id')->on('asset_types')->onDelete('set null');
            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('set null');
            $table->foreign('issuance_id')->references('id')->on('issuences')->onDelete('set null');
            $table->foreign('issuance_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('transfer_id')->references('id')->on('transfers')->onDelete('set null');
            $table->foreign('transfer_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('disposal_id')->references('id')->on('disposels')->onDelete('set null');
            $table->foreign('disposal_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('maintenance_id')->references('id')->on('maintenances')->onDelete('set null');
            $table->foreign('maintenance_by')->references('id')->on('suppliers')->onDelete('set null');
            $table->foreign('return_id')->references('id')->on('asset_returns')->onDelete('set null');
            $table->foreign('return_by')->references('id')->on('users')->onDelete('set null');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timelines');
    }
};
