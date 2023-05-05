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
            3 => 
            array (
                'created_at' => '2023-05-05 05:52:25',
                'day' => 'Monday',
                'end_time' => '21:30:00',
                'id' => 4,
                'sectionid' => 2,
                'start_time' => '08:00:00',
                'subjectid' => 1,
                'teacherid' => 1,
                'updated_at' => '2023-05-05 05:52:25',
                'userid' => 4,
            ),
            4 => 
            array (
                'created_at' => '2023-05-05 05:53:01',
                'day' => 'Tuesday',
                'end_time' => '11:00:00',
                'id' => 5,
                'sectionid' => 2,
                'start_time' => '10:00:00',
                'subjectid' => 2,
                'teacherid' => 5,
                'updated_at' => '2023-05-05 05:53:01',
                'userid' => 6,
            ),
            5 => 
            array (
                'created_at' => '2023-05-05 05:53:17',
                'day' => 'Tuesday',
                'end_time' => '13:30:00',
                'id' => 6,
                'sectionid' => 2,
                'start_time' => '12:00:00',
                'subjectid' => 3,
                'teacherid' => 7,
                'updated_at' => '2023-05-05 05:53:17',
                'userid' => 6,
            ),
            6 => 
            array (
                'created_at' => '2023-05-05 05:58:26',
                'day' => 'Wednesday',
                'end_time' => '13:00:00',
                'id' => 7,
                'sectionid' => 2,
                'start_time' => '11:00:00',
                'subjectid' => 4,
                'teacherid' => 8,
                'updated_at' => '2023-05-05 05:58:26',
                'userid' => 10,
            ),
            7 => 
            array (
                'created_at' => '2023-05-05 05:58:54',
                'day' => 'Friday',
                'end_time' => '14:00:00',
                'id' => 8,
                'sectionid' => 2,
                'start_time' => '13:00:00',
                'subjectid' => 7,
                'teacherid' => 11,
                'updated_at' => '2023-05-05 05:58:54',
                'userid' => 6,
            ),
        ));
        
        
    }
}