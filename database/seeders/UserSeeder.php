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
                $campos = config('csv.CSV_FIELDS');

                return [
                        $campos[0] => $row[0],
                        $campos[1] =>  $row[1],
                        $campos[2] => $row[2],
                        $campos[3] => Hash::make($row[3]), // Encripta la contraseña
                        $campos[4] => $row[4],
                        $campos[5] => $row[5],
                        $campos[6] => $row[6],
                        $campos[7] => $row[7],
                        $campos[8] => $row[8],
                        $campos[9] => $row[9],
                        $campos[10] => $row[10],
                        $campos[11] => $row[11],
                        $campos[12] => $row[12],
                        $campos[13] => $row[13],
                    ];
                })->toArray();

                DB::table('users')->insert($records);
            });
    }

}
