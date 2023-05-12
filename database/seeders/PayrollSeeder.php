<?php

namespace Database\Seeders;

use App\Models\payroll;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;


class PayrollSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = FakerFactory::create('es_ES');
        $user = User::pluck('id');

        for ($i = 0; $i < 100; $i++) {
            payroll::create([
                'user_id' => $faker->randomElement($user),
                'gross_salary' => $faker->random_int(1500, 4000),
                'base_salary' => $faker->random_int(700, 3000),
                'income_tax' => $faker->random_int(19, 20),
                'allowances' => $faker->random_int(19, 20),
                'concept' => $faker->sentence,
            ]);
        }
    }
}
