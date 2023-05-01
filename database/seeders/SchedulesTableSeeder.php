<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SchedulesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('schedules')->delete();
        
        \DB::table('schedules')->insert(array (
            0 => 
            array (
                'created_at' => '2023-05-01 16:00:01',
                'day' => 'Monday',
                'end_time' => '10:00:00',
                'id' => 1,
                'sectionid' => 1,
                'start_time' => '08:00:00',
                'subjectid' => 2,
                'teacherid' => 5,
                'updated_at' => '2023-05-01 16:00:01',
            ),
            1 => 
            array (
                'created_at' => '2023-05-01 16:00:23',
                'day' => 'Monday',
                'end_time' => '12:00:00',
                'id' => 2,
                'sectionid' => 1,
                'start_time' => '10:00:00',
                'subjectid' => 2,
                'teacherid' => 6,
                'updated_at' => '2023-05-01 16:00:23',
            ),
        ));
        
        
    }
}