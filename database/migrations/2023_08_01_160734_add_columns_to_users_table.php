<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add new columns
            $table->string('last_name')->nullable();
            $table->string('profile_photo')->nullable();
            $table->string('cover_photo')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->unsignedBigInteger('user_added_by')->nullable();
            $table->boolean('active')->default(1);

            // Define foreign key constraints
            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onDelete('set null');


            $table->foreign('user_added_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the added columns
            $table->dropColumn(['last_name', 'profile_photo', 'cover_photo', 'department_id', 'designation_id', 'user_added_by', 'active']);
        });
    }
}
