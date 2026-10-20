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
        Schema::table('orders', function (Blueprint $table) {
             $table->string('order_number')->nullable()->unique();

            $table->string('payment_method')->nullable();
            $table->string('payment_status')->nullable();

            $table->decimal('shipping_fee', 8, 2)->default(0);

            $table->string('phone')->nullable();
            $table->string('shipping_address')->nullable();
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'order_number',
                'payment_method',
                'payment_status',
                'shipping_fee',
                'phone',
                'shipping_address',
                'notes'
            ]);
        });
    }
};
