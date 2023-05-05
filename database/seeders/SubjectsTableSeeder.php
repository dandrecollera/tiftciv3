<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SubjectsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('subjects')->delete();
        
        \DB::table('subjects')->insert(array (
            0 => 
            array (
                'created_at' => '2023-04-25 07:30:40',
                'id' => 1,
                'subject_name' => 'Main Subject',
                'updated_at' => '2023-04-25 07:30:40',
            ),
            1 => 
            array (
                'created_at' => '2023-04-25 07:30:45',
                'id' => 2,
                'subject_name' => 'Subject 2',
                'updated_at' => '2023-04-25 07:30:45',
            ),
            2 => 
            array (
                'created_at' => '2023-04-25 07:30:48',
                'id' => 3,
                'subject_name' => 'Subject 3',
                'updated_at' => '2023-04-25 07:30:48',
            ),
            3 => 
            array (
                'created_at' => '2023-05-05 05:53:36',
                'id' => 4,
                'subject_name' => 'Mathematics 1',
                'updated_at' => '2023-05-05 05:53:36',
            ),
            4 => 
            array (
                'created_at' => '2023-05-05 05:53:44',
                'id' => 5,
                'subject_name' => 'Biology 1',
                'updated_at' => '2023-05-05 05:53:44',
            ),
            5 => 
            array (
                'created_at' => '2023-05-05 05:53:50',
                'id' => 6,
                'subject_name' => 'General Math 1',
                'updated_at' => '2023-05-05 05:53:50',
            ),
            6 => 
            array (
                'created_at' => '2023-05-05 05:53:58',
                'id' => 7,
                'subject_name' => 'English 2',
                'updated_at' => '2023-05-05 05:53:58',
            ),
        ));
        
        
    }
}