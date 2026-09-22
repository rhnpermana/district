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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'loyalty_points')) {
                $table->integer('loyalty_points')->default(0)->after('role');
            }
            if (!Schema::hasColumn('users', 'member_tier')) {
                $table->string('member_tier', 20)->default('Silver')->after('loyalty_points');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumnIfExists('loyalty_points');
            $table->dropColumnIfExists('member_tier');
        });
    }
};
