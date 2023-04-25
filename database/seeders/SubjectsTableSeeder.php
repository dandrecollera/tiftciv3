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
                'id' => 1,
                'subject_name' => 'Main Subject',
                'created_at' => '2023-04-25 07:30:40',
                'updated_at' => '2023-04-25 07:30:40',
            ),
            1 => 
            array (
                'id' => 2,
                'subject_name' => 'Subject 2',
                'created_at' => '2023-04-25 07:30:45',
                'updated_at' => '2023-04-25 07:30:45',
            ),
            2 => 
            array (
                'id' => 3,
                'subject_name' => 'Subject 3',
                'created_at' => '2023-04-25 07:30:48',
                'updated_at' => '2023-04-25 07:30:48',
            ),
        ));
        
        
    }
}