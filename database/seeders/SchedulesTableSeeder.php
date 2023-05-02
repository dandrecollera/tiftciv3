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
                'created_at' => '2023-05-02 02:53:55',
                'day' => 'Monday',
                'end_time' => '09:30:00',
                'id' => 1,
                'sectionid' => 1,
                'start_time' => '08:00:00',
                'subjectid' => 1,
                'teacherid' => 1,
                'updated_at' => '2023-05-02 02:53:55',
                'userid' => 4,
            ),
            1 => 
            array (
                'created_at' => '2023-05-02 02:54:10',
                'day' => 'Monday',
                'end_time' => '11:00:00',
                'id' => 2,
                'sectionid' => 1,
                'start_time' => '09:30:00',
                'subjectid' => 2,
                'teacherid' => 4,
                'updated_at' => '2023-05-02 02:54:10',
                'userid' => 5,
            ),
            2 => 
            array (
                'created_at' => '2023-05-02 02:54:41',
                'day' => 'Monday',
                'end_time' => '13:30:00',
                'id' => 3,
                'sectionid' => 1,
                'start_time' => '12:00:00',
                'subjectid' => 3,
                'teacherid' => 7,
                'updated_at' => '2023-05-02 02:54:41',
                'userid' => 6,
            ),
        ));
        
        
    }
}