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
        Schema::table('seller_requests', function (Blueprint $table) {
            $table->string('full_name')->after('user_id');
            $table->text('address')->after('full_name');
            $table->string('phone_number')->after('address');
            $table->string('business_name')->after('phone_number');
            $table->text('business_address')->after('business_name');
            $table->string('business_phone_number')->after('business_address');
            $table->text('business_description')->after('business_phone_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seller_requests', function (Blueprint $table) {
            $table->dropColumn([
                'full_name',
                'address',
                'phone_number',
                'business_name',
                'business_address',
                'business_phone_number',
                'business_description',
            ]);
        });
    }
};
