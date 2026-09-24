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
            $table->enum('role', ['super_admin', 'admin', 'corporate_employee', 'free_user'])->default('free_user')->after('account_type');
            $table->foreignId('corporate_id')->nullable()->after('role')->constrained('corporates')->nullOnDelete();
            $table->boolean('is_verified')->default(true)->after('corporate_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['corporate_id']);
            $table->dropColumn(['role', 'corporate_id', 'is_verified']);
        });
    }
};
