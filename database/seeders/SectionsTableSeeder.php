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
                'created_at' => '2023-04-30 16:15:55',
                'id' => 1,
                'section_name' => 'ABM 11-A',
                'strand' => 'ABM',
                'updated_at' => '2023-04-30 16:15:55',
                'yearlevel' => '11',
            ),
            1 => 
            array (
                'created_at' => '2023-04-30 16:21:35',
                'id' => 2,
                'section_name' => 'HE A-12',
                'strand' => 'HE',
                'updated_at' => '2023-04-30 16:21:35',
                'yearlevel' => '12',
            ),
        ));
        
        
    }
}