<?php

namespace Database\Seeders;

use App\Models\Payroll;
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
        $users = User::pluck('id');

        for ($i = 0; $i < 200; $i++) {
            $date = $faker->dateTimeBetween('-3 years', 'now');
            $month = $date->format('m');
            $year = $date->format('Y');

            Payroll::create([
                'user_id' => $faker->randomElement($users),
                'gross_salary' => $faker->numberBetween(1500, 4000),
                'base_salary' => $faker->numberBetween(700, 3000),
                'income_tax' => $faker->numberBetween(19, 20),
                'destination_allowance' => $faker->numberBetween(19, 20),
                'specific_allowance' => $faker->numberBetween(19, 20),
                'commission_attendance' => $faker->numberBetween(19, 20),
                'common_contingencies' => $faker->numberBetween(19, 20),
                'unemployment' => $faker->numberBetween(19, 20),
                'mei' => $faker->numberBetween(19, 20),
                'professional_training' => $faker->numberBetween(19, 20),
                'csic' => $faker->numberBetween(19, 20),
                'concept' => $faker->sentence,
                'month' => $month,
                'year' => $year,
            ]);
        }
    }
}
