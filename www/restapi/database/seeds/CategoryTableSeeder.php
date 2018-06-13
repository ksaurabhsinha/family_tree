<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for ($i = 0; $i < 50; $i++) {

            $parentIds = DB::table("categories")
                ->select("categories.id")
                ->orderBy(DB::raw('RAND()'))
                ->take(1)
                ->get();

            $categoryName = sprintf('%s %s', str_random(10), str_random(8));

            $data = [
                'id' => \Webpatser\Uuid\Uuid::generate()->string,
                'name' => $categoryName,
                'slug' => str_slug($categoryName),
                'parent_id' => !empty($parentIds[0]) ? $parentIds[0]->id : null,
                'is_visible' => (string) rand(0, 1),
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ];

            DB::table('categories')->insert($data);

        }


    }
}
