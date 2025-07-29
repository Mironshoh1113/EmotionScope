<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::create([
            'name' => 'Basic',
            'price' => 9.99,
            'request_limit' => 100,
            'description' => 'Basic plan for small projects',
            'is_active' => true,
        ]);

        Plan::create([
            'name' => 'Pro',
            'price' => 19.99,
            'request_limit' => 500,
            'description' => 'Professional plan for medium projects',
            'is_active' => true,
        ]);

        Plan::create([
            'name' => 'Enterprise',
            'price' => 49.99,
            'request_limit' => 2000,
            'description' => 'Enterprise plan for large projects',
            'is_active' => true,
        ]);

        Plan::create([
            'name' => 'Free',
            'price' => 0.00,
            'request_limit' => 10,
            'description' => 'Free plan for testing',
            'is_active' => true,
        ]);
    }
} 