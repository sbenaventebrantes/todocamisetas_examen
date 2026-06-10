<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table): void {
            $table->uuid('customer_id')->primary();
            $table->string('trade_name');
            $table->string('tax_id', 50)->unique();
            $table->string('address')->nullable();
            $table->enum('category', ['preferential', 'regular']);
            $table->string('contact_name');
            $table->string('contact_email');
            $table->decimal('offer_percentage', 5, 2)->nullable();
            $table->timestamps();

            $table->index('category');
            $table->index('contact_email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
