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
        Schema::table('invoices', function (Blueprint $table) {
            // ✅ Cek dan tambah fields jika belum ada
            if (!Schema::hasColumn('invoices', 'payment_method')) {
                $table->enum('payment_method', ['bank_transfer', 'credit_card', 'e_wallet', 'manual'])->nullable()->after('end_of');
            }

            if (!Schema::hasColumn('invoices', 'va_number')) {
                $table->string('va_number')->nullable()->after('payment_method');
            }

            if (!Schema::hasColumn('invoices', 'payment_code')) {
                $table->string('payment_code')->nullable()->after('va_number');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'va_number', 'payment_code']);
        });
    }
};