<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CurriculumsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('curriculums')->delete();
        
        \DB::table('curriculums')->insert(array (
            0 => 
            array (
                'created_at' => '2023-11-05 09:57:19',
                'cstt' => '[{"endtime": "17:57", "starttime": "17:57", "subjectid": "2", "teacherid": "6"}]',
                'id' => 1,
                'name' => 'Test123',
                'schoolyear' => '2022-2023',
                'semester' => '1st',
                'status' => 'active',
                'strand' => 'ABM',
                'updated_at' => '2023-11-05 11:52:50',
                'yearlevel' => '11',
            ),
        ));
        
        
    }
}