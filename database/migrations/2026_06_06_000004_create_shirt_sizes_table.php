<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shirt_sizes', function (Blueprint $table): void {
            $table->uuid('shirt_size_id')->primary()->default(DB::raw('(UUID())'));
            $table->foreignUuid('shirt_id')->constrained('shirts', 'product_id')->cascadeOnDelete();
            $table->foreignUuid('size_id')->constrained('sizes', 'size_id')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['shirt_id', 'size_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shirt_sizes');
    }
};
