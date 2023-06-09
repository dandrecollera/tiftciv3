<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MainUsersDetailsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('main_users_details')->delete();

        \DB::table('main_users_details')->insert(array (
            0 =>
            array (
                'id' => 1,
                'userid' => 1,
                'firstname' => 'Master Admin',
                'middlename' => 'Master',
                'lastname' => 'Admin',
                'mobilenumber' => '12345678912',
                'address' => 'Address Admin',
                'lrn' => NULL,
                'photo' => '1.png',
                'created_at' => '2023-04-23 18:19:09',
                'updated_at' => '2023-04-23 18:19:09',
            ),
            1 =>
            array (
                'id' => 2,
                'userid' => 2,
                'firstname' => 'Dandre Mitchek',
                'middlename' => 'Ranes',
                'lastname' => 'Collera',
                'mobilenumber' => '09761816840',
                'address' => 'Interior Lapu Lapu St. Tanay Rizal',
                'lrn' => NULL,
                'photo' => '2.jpg',
                'created_at' => '2023-04-25 07:24:24',
                'updated_at' => '2023-04-25 07:24:24',
            ),
            2 =>
            array (
                'id' => 3,
                'userid' => 3,
                'firstname' => 'Jaymielyn',
                'middlename' => '',
                'lastname' => 'Cruz',
                'mobilenumber' => '',
                'address' => '',
                'lrn' => NULL,
                'photo' => '3.jpg',
                'created_at' => '2023-04-25 07:25:02',
                'updated_at' => '2023-04-25 07:25:02',
            ),
            3 =>
            array (
                'id' => 4,
                'userid' => 4,
                'firstname' => 'Ralph Vincent',
                'middlename' => '',
                'lastname' => 'Extra',
                'mobilenumber' => '',
                'address' => '',
                'lrn' => NULL,
                'photo' => '4.jpg',
                'created_at' => '2023-04-25 07:25:38',
                'updated_at' => '2023-04-25 07:25:38',
            ),
            4 =>
            array (
                'id' => 5,
                'userid' => 5,
                'firstname' => 'Al Valle',
                'middlename' => '',
                'lastname' => 'Apostadero',
                'mobilenumber' => '',
                'address' => '',
                'lrn' => NULL,
                'photo' => '5.jpg',
                'created_at' => '2023-04-25 07:28:29',
                'updated_at' => '2023-04-25 07:28:29',
            ),
        ));


    }
}
