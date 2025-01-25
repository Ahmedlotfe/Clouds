<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    public function run()
    {
        Plan::insert([
            ['name' => 'Basic Plan', 'description' => 'For individuals starting out.', 'price' => 10.00, 'duration' => 30],
            ['name' => 'Pro Plan', 'description' => 'For professionals expanding their toolkit.', 'price' => 25.00, 'duration' => 90],
            ['name' => 'Enterprise Plan', 'description' => 'The ultimate package for businesses.', 'price' => 50.00, 'duration' => 365],
        ]);
    }
}

