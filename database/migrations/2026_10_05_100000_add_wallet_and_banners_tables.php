<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'wallet_id')) {
                $table->string('wallet_id')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'wallet_balance')) {
                $table->decimal('wallet_balance', 12, 2)->default(500.00)->after('wallet_id');
            }
        });

        Schema::table('meetings', function (Blueprint $table) {
            if (!Schema::hasColumn('meetings', 'price')) {
                $table->decimal('price', 10, 2)->default(0.00)->after('visibility');
            }
            if (!Schema::hasColumn('meetings', 'description')) {
                $table->text('description')->nullable()->after('title');
            }
        });

        if (!Schema::hasTable('wallet_transactions')) {
            Schema::create('wallet_transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->decimal('amount', 10, 2);
                $table->enum('type', ['credit', 'debit']);
                $table->string('description');
                $table->string('reference_id')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('app_notifications')) {
            Schema::create('app_notifications', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
                $table->string('title');
                $table->text('message');
                $table->string('type')->default('general');
                $table->string('meeting_uuid')->nullable();
                $table->boolean('is_read')->default(false);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('news_banners')) {
            Schema::create('news_banners', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('image_url')->nullable();
                $table->string('action_type')->default('news');
                $table->string('meeting_uuid')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['wallet_id', 'wallet_balance']);
        });

        Schema::table('meetings', function (Blueprint $table) {
            $table->dropColumn(['price', 'description']);
        });

        Schema::dropIfExists('wallet_transactions');
        Schema::dropIfExists('app_notifications');
        Schema::dropIfExists('news_banners');
    }
};
