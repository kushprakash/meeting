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
        Schema::table('settings', function (Blueprint $table) {
            $table->text('about_title')->nullable();
            $table->longText('about_text')->nullable();
            $table->json('services_json')->nullable();
            $table->json('media_json')->nullable();
            $table->string('contact_address')->nullable();
            $table->string('contact_phone')->nullable();
            $table->json('social_links_json')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'about_title',
                'about_text',
                'services_json',
                'media_json',
                'contact_address',
                'contact_phone',
                'social_links_json',
            ]);
        });
    }
};
