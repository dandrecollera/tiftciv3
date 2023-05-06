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
                'semester' => '1st',
                'subject_name' => 'Main Subject 1',
                'updated_at' => '2023-04-25 07:30:40',
            ),
            1 =>
            array (
                'created_at' => '2023-04-25 07:30:45',
                'id' => 2,
                'semester' => '2nd',
                'subject_name' => 'Main Subject 2',
                'updated_at' => '2023-04-25 07:30:45',
            ),
            2 =>
            array (
                'created_at' => '2023-04-25 07:30:48',
                'id' => 3,
                'semester' => '1st',
                'subject_name' => 'English 1',
                'updated_at' => '2023-04-25 07:30:48',
            ),
            3 =>
            array (
                'created_at' => '2023-05-05 05:53:36',
                'id' => 4,
                'semester' => '1st',
                'subject_name' => 'Mathematics 1',
                'updated_at' => '2023-05-05 05:53:36',
            ),
            4 =>
            array (
                'created_at' => '2023-05-05 05:53:44',
                'id' => 5,
                'semester' => '1st',
                'subject_name' => 'Biology 1',
                'updated_at' => '2023-05-05 05:53:44',
            ),
            5 =>
            array (
                'created_at' => '2023-05-05 05:53:50',
                'id' => 6,
                'semester' => '2nd',
                'subject_name' => 'Mathematics 2',
                'updated_at' => '2023-05-05 05:53:50',
            ),
            6 =>
            array (
                'created_at' => '2023-05-05 05:53:58',
                'id' => 7,
                'subject_name' => 'English 2',
                'semester' => '2nd',
                'updated_at' => '2023-05-05 05:53:58',
            ),
        ));


    }
}
