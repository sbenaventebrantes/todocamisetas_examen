<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Shirt;
use App\Models\Size;
use Illuminate\Database\Seeder;

class ShirtSeeder extends Seeder
{
    public function run(): void
    {
        $preferentialCustomer = Customer::query()->where('trade_name', '90minutos')->firstOrFail();
        $regularCustomer = Customer::query()->where('trade_name', 'tdeportes')->firstOrFail();

        $shirt1 = Shirt::query()->updateOrCreate([
            'product_code' => 'SH-0001',
        ], [
            'customer_id' => $preferentialCustomer->customer_id,
            'title' => 'Home 90minutos 2026',
            'club' => '90minutos FC',
            'country' => 'España',
            'type' => 'home',
            'color' => 'rojo',
            'price' => 79.90,
            'price_offer' => 64.90,
            'details' => 'Edición de ejemplo para la demo.',
        ]);

        $shirt2 = Shirt::query()->updateOrCreate([
            'product_code' => 'SH-0002',
        ], [
            'customer_id' => $regularCustomer->customer_id,
            'title' => 'Away tdeportes 2026',
            'club' => 'tdeportes Club',
            'country' => 'Argentina',
            'type' => 'away',
            'color' => 'azul',
            'price' => 74.50,
            'price_offer' => null,
            'details' => 'Segunda camiseta de muestra.',
        ]);

        $sizeIds = Size::query()->whereIn('name', ['S', 'M', 'L', 'XL'])->pluck('size_id');

        $shirt1->sizes()->syncWithoutDetaching($sizeIds->take(3)->all());
        $shirt2->sizes()->syncWithoutDetaching($sizeIds->take(2)->all());
    }
}
