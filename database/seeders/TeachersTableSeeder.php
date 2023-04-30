<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TeachersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('teachers')->delete();
        
        \DB::table('teachers')->insert(array (
            0 => 
            array (
                'created_at' => '2023-04-30 06:33:28',
                'id' => 1,
                'subjectid' => 1,
                'updated_at' => '2023-04-30 06:33:28',
                'userid' => 4,
            ),
            1 => 
            array (
                'created_at' => '2023-04-30 06:33:48',
                'id' => 4,
                'subjectid' => 2,
                'updated_at' => '2023-04-30 06:33:48',
                'userid' => 5,
            ),
            2 => 
            array (
                'created_at' => '2023-04-30 06:33:50',
                'id' => 5,
                'subjectid' => 2,
                'updated_at' => '2023-04-30 06:33:50',
                'userid' => 6,
            ),
            3 => 
            array (
                'created_at' => '2023-04-30 06:34:03',
                'id' => 6,
                'subjectid' => 3,
                'updated_at' => '2023-04-30 06:34:03',
                'userid' => 4,
            ),
            4 => 
            array (
                'created_at' => '2023-04-30 06:34:10',
                'id' => 7,
                'subjectid' => 3,
                'updated_at' => '2023-04-30 06:34:10',
                'userid' => 6,
            ),
        ));
        
        
    }
}