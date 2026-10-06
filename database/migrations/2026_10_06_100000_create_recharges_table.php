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
        if (!Schema::hasTable('recharges')) {
            Schema::create('recharges', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('order_id')->index();
                $table->string('txn_id')->nullable()->index();
                $table->string('number');
                $table->string('operator');
                $table->string('circle')->nullable();
                $table->decimal('amount', 12, 2);
                $table->tinyInteger('type')->default(1)->comment('1: Mobile, 2: DTH, 3: Bill Payment');
                $table->tinyInteger('status')->default(2)->comment('0: Failed, 1: Success, 2: Pending');
                $table->string('status_text')->default('Pending');
                $table->string('res_text')->nullable();
                
                // Bill payment extra fields
                $table->string('fetch_ref_id')->nullable();
                $table->string('bill_number')->nullable();
                $table->string('customer_name')->nullable();
                $table->string('due_date')->nullable();
                
                $table->json('response_json')->nullable();
                $table->decimal('commission_amount', 12, 2)->default(0.00);
                $table->boolean('commission_status')->default(false);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recharges');
    }
};
