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
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->after('password');
            $table->date('date_of_birth')->nullable()->after('avatar');
            $table->string('gender')->nullable()->after('date_of_birth');
            $table->string('phone_number')->nullable()->after('gender');
            $table->text('address')->nullable()->after('phone_number');
            $table->string('role')->after('address');
            $table->string('status')->after('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'avatar',
                'date_of_birth',
                'gender',
                'phone_number',
                'address',
                'role',
                'status',
            ]);
        });
    }
};
