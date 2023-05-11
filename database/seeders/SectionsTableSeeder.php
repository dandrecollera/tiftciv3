<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SectionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sections')->delete();
        
        \DB::table('sections')->insert(array (
            0 => 
            array (
                'id' => 1,
                'section_name' => 'fasdfdasas',
                'strand' => 'ABM',
                'yearlevel' => '11',
                'created_at' => '2023-05-11 04:38:25',
                'updated_at' => '2023-05-11 04:38:25',
            ),
        ));
        
        
    }
}