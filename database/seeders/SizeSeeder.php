<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['XS', 'S', 'M', 'L', 'XL'] as $name) {
            Size::query()->updateOrCreate(['name' => $name]);
        }
    }
}
