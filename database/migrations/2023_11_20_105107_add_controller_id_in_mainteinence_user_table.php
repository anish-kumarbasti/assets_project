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
        Schema::table('maintenance_users', function (Blueprint $table) {
            $table->unsignedBigInteger('controller_id')->after('perform_by_user');
            $table->timestamp('date_time')->after('transaction_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maintenance_users', function (Blueprint $table) {
            //
        });
    }
};
