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
        // 1. Update Users Table
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'work_status')) {
                $table->string('work_status')->default('Available'); // Available, On Duty, Break, Off
            }
            if (!Schema::hasColumn('users', 'commission_rate')) {
                $table->integer('commission_rate')->default(30); // percentage 30%
            }
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable();
            }
        });

        // 2. Update Bookings Table
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'queue_number')) {
                $table->string('queue_number')->nullable();
            }
            if (!Schema::hasColumn('bookings', 'type')) {
                $table->string('type')->default('online'); // online, walkin
            }
            if (!Schema::hasColumn('bookings', 'arrived_at')) {
                $table->timestamp('arrived_at')->nullable();
            }
            if (!Schema::hasColumn('bookings', 'price')) {
                $table->decimal('price', 10, 2)->default(75000);
            }
        });

        // 3. Services Table
        if (!Schema::hasTable('services')) {
            Schema::create('services', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('category')->default('Haircut');
                $table->decimal('price', 10, 2);
                $table->integer('duration_minutes')->default(45);
                $table->text('description')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // 4. Products Table
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('category')->default('Pomade');
                $table->decimal('price', 10, 2);
                $table->integer('stock')->default(0);
                $table->integer('min_stock')->default(5);
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        // 5. Vouchers Table
        if (!Schema::hasTable('vouchers')) {
            Schema::create('vouchers', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique();
                $table->string('type')->default('fixed'); // percent, fixed
                $table->decimal('discount_value', 10, 2);
                $table->decimal('min_spend', 10, 2)->default(0);
                $table->date('valid_until')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // 6. Portfolios Table
        if (!Schema::hasTable('portfolios')) {
            Schema::create('portfolios', function (Blueprint $table) {
                $table->id();
                $table->foreignId('stylist_id')->constrained('users')->onDelete('cascade');
                $table->string('title');
                $table->string('image_path');
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        // 7. Reviews Table
        if (!Schema::hasTable('reviews')) {
            Schema::create('reviews', function (Blueprint $table) {
                $table->id();
                $table->foreignId('booking_id')->nullable()->constrained('bookings')->onDelete('cascade');
                $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('stylist_id')->constrained('users')->onDelete('cascade');
                $table->integer('rating')->default(5);
                $table->text('comment')->nullable();
                $table->timestamps();
            });
        }

        // 8. Client Notes Table
        if (!Schema::hasTable('client_notes')) {
            Schema::create('client_notes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('stylist_id')->constrained('users')->onDelete('cascade');
                $table->text('notes');
                $table->timestamps();
            });
        }

        // 9. Transactions Table
        if (!Schema::hasTable('transactions')) {
            Schema::create('transactions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('booking_id')->nullable()->constrained('bookings')->onDelete('set null');
                $table->foreignId('cashier_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('customer_id')->nullable()->constrained('users')->onDelete('set null');
                $table->string('customer_name');
                $table->decimal('subtotal', 10, 2);
                $table->decimal('discount_amount', 10, 2)->default(0);
                $table->decimal('final_amount', 10, 2);
                $table->string('payment_method')->default('Cash'); // Cash, QRIS, E-Wallet, Card
                $table->string('payment_status')->default('paid');
                $table->timestamps();
            });
        }

        // 10. Transaction Items Table
        if (!Schema::hasTable('transaction_items')) {
            Schema::create('transaction_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('transaction_id')->constrained('transactions')->onDelete('cascade');
                $table->string('item_type'); // service, product
                $table->unsignedBigInteger('item_id')->nullable();
                $table->string('item_name');
                $table->decimal('price', 10, 2);
                $table->integer('quantity')->default(1);
                $table->decimal('subtotal', 10, 2);
                $table->timestamps();
            });
        }

        // 11. Petty Cashes Table
        if (!Schema::hasTable('petty_cashes')) {
            Schema::create('petty_cashes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('cashier_id')->constrained('users')->onDelete('cascade');
                $table->decimal('amount', 10, 2);
                $table->string('category');
                $table->text('description');
                $table->date('expense_date');
                $table->timestamps();
            });
        }

        // 12. Work Shifts Table
        if (!Schema::hasTable('work_shifts')) {
            Schema::create('work_shifts', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->date('shift_date');
                $table->string('shift_type')->default('Pagi'); // Pagi, Siang, Full, Off
                $table->string('notes')->nullable();
                $table->timestamps();
            });
        }

        // 13. Complaints Table
        if (!Schema::hasTable('complaints')) {
            Schema::create('complaints', function (Blueprint $table) {
                $table->id();
                $table->foreignId('customer_id')->nullable()->constrained('users')->onDelete('set null');
                $table->foreignId('booking_id')->nullable()->constrained('bookings')->onDelete('set null');
                $table->string('customer_name');
                $table->string('category')->default('Layanan');
                $table->text('message');
                $table->string('status')->default('pending'); // pending, in_progress, resolved
                $table->text('resolution')->nullable();
                $table->timestamps();
            });
        }

        // 14. System Logs Table
        if (!Schema::hasTable('system_logs')) {
            Schema::create('system_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
                $table->string('action');
                $table->text('details')->nullable();
                $table->string('ip_address')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_logs');
        Schema::dropIfExists('complaints');
        Schema::dropIfExists('work_shifts');
        Schema::dropIfExists('petty_cashes');
        Schema::dropIfExists('transaction_items');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('client_notes');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('portfolios');
        Schema::dropIfExists('vouchers');
        Schema::dropIfExists('products');
        Schema::dropIfExists('services');
    }
};
