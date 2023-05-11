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
                'created_at' => '2023-05-10 21:00:20',
                'id' => 1,
                'school_year' => '2021-2022',
                'status' => 'active',
                'updated_at' => '2023-05-10 21:00:20',
            ),
            1 => 
            array (
                'created_at' => '2023-05-10 13:01:58',
                'id' => 2,
                'school_year' => '2022-2023',
                'status' => 'active',
                'updated_at' => '2023-05-10 13:01:58',
            ),
        ));
        
        
    }
}