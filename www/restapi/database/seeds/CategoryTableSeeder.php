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

        for($i=0; $i<50; $i++) {

            $parentIds = DB::table("categories")
                ->select("categories.id")
                ->orderBy(DB::raw('RAND()'))
                ->take(1)
                ->get();

            $data = [

                'name' => str_random(10),
                'parent_id' => !empty($parentIds[0]) ? $parentIds[0]->id : 0,
                'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ];

            DB::table('categories')->insert($data);

        }


    }
}
