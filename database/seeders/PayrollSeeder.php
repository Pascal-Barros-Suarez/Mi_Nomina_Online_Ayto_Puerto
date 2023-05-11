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

        for($i = 0; $i < 100 ; $i++) {
        payroll::create([
        'id_usuario'=>$faker->randomElement($user),
        'sueldo_bruto'=>$faker->random_int(1500,4000),
        'sueldo_base'=>$faker->random_int(700,3000),
        'irpf'=>$faker->random_int(19,20),
        'complementos'=>$faker->random_int(19,20),
        'concepto'=>$faker->sentence,
        ]);
        }
    }
}

//PARA FECHA DATETAME 