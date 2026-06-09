<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        Customer::query()->updateOrCreate([
            'tax_id' => '90MINUTOS-001',
        ], [
            'trade_name' => '90minutos',
            'address' => 'Calle Demo 90, Madrid',
            'category' => 'preferential',
            'contact_name' => 'Ana García',
            'contact_email' => 'ana@90minutos.test',
            'offer_percentage' => 15,
        ]);

        Customer::query()->updateOrCreate([
            'tax_id' => 'TDEPORTES-001',
        ], [
            'trade_name' => 'tdeportes',
            'address' => 'Avenida Demo 12, Barcelona',
            'category' => 'regular',
            'contact_name' => 'Luis Pérez',
            'contact_email' => 'luis@tdeportes.test',
            'offer_percentage' => null,
        ]);
    }
}
