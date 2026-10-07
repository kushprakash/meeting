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
        Schema::table('fund_requests', function (Blueprint $table) {
            $table->json('iniciate_request_data')->nullable()->after('payment_url');
            $table->json('iniciate_response_data')->nullable()->after('iniciate_request_data');
            $table->json('verify_request_data')->nullable()->after('iniciate_response_data');
            $table->json('verify_response_data')->nullable()->after('verify_request_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fund_requests', function (Blueprint $table) {
            $table->dropColumn([
                'iniciate_request_data',
                'iniciate_response_data',
                'verify_request_data',
                'verify_response_data',
            ]);
        });
    }
};
