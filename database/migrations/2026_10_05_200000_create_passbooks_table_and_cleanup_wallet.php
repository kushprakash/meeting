<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Create passbooks table
        if (! Schema::hasTable('passbooks')) {
            Schema::create('passbooks', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('details');
                $table->enum('type', ['CR', 'DR']);
                $table->decimal('pre_balance', 12, 2)->default(0.00);
                $table->decimal('amount', 12, 2)->default(0.00);
                $table->decimal('balance', 12, 2)->default(0.00);
                $table->timestamps();
            });
        }

        // 2. Drop legacy wallet_transactions table if exists
        Schema::dropIfExists('wallet_transactions');

        // 3. Drop wallet_id & wallet_balance from users table if exist
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'wallet_id')) {
                $table->dropColumn('wallet_id');
            }
            if (Schema::hasColumn('users', 'wallet_balance')) {
                $table->dropColumn('wallet_balance');
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('passbooks');
    }
};
