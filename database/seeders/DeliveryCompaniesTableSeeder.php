<?php

namespace Database\Seeders;

use App\Models\DeliveryCompany;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DeliveryCompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Schema::hasTable('delivery_companies')) {
            $companiesData = collect([
                ['name' => 'Pgeon'],
                ['name' => 'Pos Laju'],
                ['name' => 'GD Express (GDex)'],
                ['name' => 'City-Link Express'],
                ['name' => 'Ninja Van'],
                ['name' => 'Aramex'],
                ['name' => 'DHL'],
                ['name' => 'Lalamove'],
                ['name' => 'ABX'],
                ['name' => 'J&T Express'],
                ['name' => 'Skynet'],
                ['name' => 'TA-Q-BIN'],
                ['name' => 'FedEx'],
                ['name' => 'LEL Express (LEX)'],
                ['name' => 'Shopee Express'],
            ]);

            $companiesData->each(function ($company) {
                DeliveryCompany::firstOrCreate($company);
            });
        }
    }
}
