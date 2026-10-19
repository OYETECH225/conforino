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
        Schema::table('contact_requests', function (Blueprint $table) {
            $table->foreignId('service_id')->nullable()->after('surface')->constrained()->nullOnDelete();
            $table->string('beneficiary_type')->nullable()->after('service_id');
            $table->string('address')->nullable()->after('city');
            $table->string('preferred_day')->nullable()->after('beneficiary_type');
            $table->string('preferred_time_slot')->nullable()->after('preferred_day');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_requests', function (Blueprint $table) {
            $table->dropConstrainedForeignId('service_id');
            $table->dropColumn(['beneficiary_type', 'address', 'preferred_day', 'preferred_time_slot']);
        });
    }
};
