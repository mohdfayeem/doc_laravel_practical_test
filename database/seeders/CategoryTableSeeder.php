<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'id' => 1,
                'parent_id' => null,
                'name' => 'Cat 1',
                'email' => 'cat1@yopmail.com',
            ],
            [
                'id' => 2,
                'parent_id' => null,
                'name' => 'Cat 2',
                'email' => 'cat2@yopmail.com',
            ],
            [
                'id' => 3,
                'parent_id' => 1,
                'name' => 'Sub 1',
                'email' => 'subcat1@yopmail.com',
            ],
            [
                'id' => 4,
                'parent_id' => 1,
                'name' => 'Sub 2',
                'email' => 'subcat2@yopmail.com',
            ],
            [
                'id' => 5,
                'parent_id' => 2,
                'name' => 'Sub 1',
                'email' => 'subcat3@yopmail.com',
            ],
            [
                'id' => 6,
                'parent_id' => 2,
                'name' => 'Sub 2',
                'email' => 'subcat4@yopmail.com',
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}
