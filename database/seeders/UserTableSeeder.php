<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        factory(\Juzaweb\Models\User::class, 1)->create([
            'is_admin' => 1
        ]);

        factory(\Juzaweb\Models\User::class, 10)->create();
    }
}
