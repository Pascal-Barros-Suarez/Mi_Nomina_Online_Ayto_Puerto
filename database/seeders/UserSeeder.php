<?php
//https://techvblogs.com/blog/importing-large-csv-files-in-mysql-using-laravel
namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=UserSeeder
     */


    public function run()
    {
        LazyCollection::make(function () {
            $handle = fopen(public_path("users.csv"), 'r');

            while (($line = fgetcsv($handle, 4096)) !== false) {
                $dataString = implode(", ", $line);
                $row = explode(';', $dataString);
                yield $row;
            }

            fclose($handle);
        })
            ->skip(1)
            ->chunk(1000)
            ->each(function (LazyCollection $chunk) {
                $records = $chunk->map(function ($row) {
                    return [
                        "name" => $row[0],
                        "dni" =>  $row[1],
                        "email" => $row[2],
                        "password" => Hash::make($row[3]), // Encripta la contraseña
                        "department" => $row[4],
                    ];
                })->toArray();

                DB::table('users')->insert($records);
            });
    }

}
