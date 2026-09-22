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
        Schema::table('transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('transactions', 'midtrans_order_id')) {
                $table->string('midtrans_order_id')->nullable()->unique()->after('payment_method');
            }
            if (!Schema::hasColumn('transactions', 'qris_url')) {
                $table->text('qris_url')->nullable()->after('midtrans_order_id');
            }
            if (!Schema::hasColumn('transactions', 'qris_string')) {
                $table->text('qris_string')->nullable()->after('qris_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumnIfExists('midtrans_order_id');
            $table->dropColumnIfExists('qris_url');
            $table->dropColumnIfExists('qris_string');
        });
    }
};
