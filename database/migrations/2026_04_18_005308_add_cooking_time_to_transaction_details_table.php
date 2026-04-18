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
        Schema::table('transaction_details', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('qty');
            $table->timestamp('cooking_started_at')->nullable()->after('status');
            $table->timestamp('cooking_finished_at')->nullable()->after('cooking_started_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_details', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'cooking_started_at',
                'cooking_finished_at'
            ]);
        });
    }
};
