<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Generator;
use Faker\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UsersPasswordReset extends Seeder
{
    public function run()
    {
        $password = bcrypt('123');
        DB::update('update users set password = ?', [$password]);
    }
}
