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
                        $campos[5] => str_replace(',', '', floatval($row[5])), //combierte la anotacion cientifica del excel en numero entero
                        $campos[6] => $row[6],
                        $campos[7] =>  \DateTime::createFromFormat('d-m-Y', str_replace('/', '-', $row[7]))->format('Y-m-d'), //dice que el formato es 'd-m-y' ademas que al recoger el campo el excel cambia '/' por '-'
                        $campos[8] => $row[8],
                        $campos[9] => $row[9],
                        $campos[10] => $row[10],
                        $campos[11] => $row[11],
                        $campos[12] => $row[12],
                    ];
                })->toArray();

                DB::table('users')->insert($records);
            });
    }
}
