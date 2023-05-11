<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SchoolyearsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('schoolyears')->delete();
        
        \DB::table('schoolyears')->insert(array (
            0 => 
            array (
                'id' => 1,
                'school_year' => '2021-2022',
                'status' => 'active',
                'created_at' => '2023-05-10 21:00:20',
                'updated_at' => '2023-05-10 21:00:20',
            ),
            1 => 
            array (
                'id' => 2,
                'school_year' => '2022-2023',
                'status' => 'active',
                'created_at' => '2023-05-10 13:01:58',
                'updated_at' => '2023-05-10 13:01:58',
            ),
        ));
        
        
    }
}