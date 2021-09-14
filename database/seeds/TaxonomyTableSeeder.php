<?php

use Illuminate\Database\Seeder;

class TaxonomyTableSeeder extends Seeder
{
    public function run()
    {
        factory(\Juzaweb\Models\Taxonomy::class, 10)->create();
    }
}
