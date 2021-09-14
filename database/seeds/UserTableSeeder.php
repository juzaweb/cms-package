<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        factory(\Juzaweb\Models\User::class, 10)->create();
    }
}
