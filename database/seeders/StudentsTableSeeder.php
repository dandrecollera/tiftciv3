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
                'userid' => 7,
                'sectionid' => 2,
                'created_at' => '2023-05-04 18:50:48',
                'updated_at' => '2023-05-04 19:14:15',
            ),
            1 => 
            array (
                'id' => 2,
                'userid' => 8,
                'sectionid' => 2,
                'created_at' => '2023-05-04 19:12:15',
                'updated_at' => '2023-05-04 19:12:15',
            ),
            2 => 
            array (
                'id' => 3,
                'userid' => 9,
                'sectionid' => 2,
                'created_at' => '2023-05-04 19:13:51',
                'updated_at' => '2023-05-04 19:13:51',
            ),
        ));
        
        
    }
}