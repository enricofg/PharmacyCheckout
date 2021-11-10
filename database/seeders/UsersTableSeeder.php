<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Generator;
use Faker\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    private $numberOfClientes = 100;
    private $numberOfFarmaceuticos = 5;

    public function run()
    {
        DB::table('users')->truncate();

        $faker = Factory::create('pt_PT');
        for ($i = 1; $i <= $this->numberOfFarmaceuticos; ++$i) {
            DB::table('users')->insert($this->fakeUser($faker, $i, 'F'));
        }
        for ($i = 1; $i <= $this->numberOfClientes; ++$i) {
            DB::table('users')->insert($this->fakeUser($faker, $i, 'C'));
        }
    }

    private function fakeUser(Generator $faker, $idx, $tipo_user = 'C')
    {
        static $password;
        $createdAt = Carbon::now()->subDays(30);
        $updatedAt = $faker->dateTimeBetween($createdAt);
        return [
            'name' => ($tipo_user == 'C' ? 'Cliente ' : 'Farmacêutico ') . $idx,
            'email' => $tipo_user . $idx . '@mail.pt',
            'tipo_user' => $tipo_user,
            'password' => $password ?: $password = bcrypt('123'),
            'remember_token' => Str::random(10),
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }
}
