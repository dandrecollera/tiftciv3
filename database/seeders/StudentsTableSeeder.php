<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StudentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('students')->delete();
        
        \DB::table('students')->insert(array (
            0 => 
            array (
                'id' => 1,
                'userid' => 6,
                'sectionid' => 1,
                'created_at' => '2023-05-11 04:38:50',
                'updated_at' => '2023-05-11 04:38:50',
            ),
        ));
        
        
    }
}