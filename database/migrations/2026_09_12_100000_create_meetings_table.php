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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('title');
            $table->foreignId('host_id')->constrained('users')->onDelete('cascade');
            $table->enum('visibility', ['private', 'public'])->default('public');
            $table->boolean('approval_required')->default(true);
            $table->enum('status', ['scheduled', 'active', 'ended'])->default('active');
            $table->integer('max_participants')->nullable();
            
            // Feature permissions
            $table->boolean('allow_audio')->default(true);
            $table->boolean('allow_video')->default(true);
            $table->boolean('allow_screen_share')->default(true);
            $table->boolean('allow_chat')->default(true);
            
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
