<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shirts', function (Blueprint $table): void {
            $table->uuid('product_id')->primary();
            $table->foreignUuid('customer_id')->constrained('customers', 'customer_id')->restrictOnDelete();
            $table->string('title');
            $table->string('club');
            $table->string('country');
            $table->string('type');
            $table->string('color');
            $table->decimal('price', 10, 2);
            $table->decimal('price_offer', 10, 2)->nullable();
            $table->text('details')->nullable();
            $table->string('product_code')->unique();
            $table->timestamps();

            $table->index('customer_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shirts');
    }
};
