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
                'address' => 'Address Admin',
                'created_at' => '2023-04-23 18:19:09',
                'firstname' => 'Master Admin',
                'id' => 1,
                'lastname' => 'Admin',
                'lrn' => NULL,
                'middlename' => 'Master',
                'mobilenumber' => '12345678912',
                'photo' => '1.png',
                'strand' => NULL,
                'updated_at' => '2023-04-23 18:19:09',
                'userid' => 1,
                'yearlevel' => NULL,
            ),
            1 => 
            array (
                'address' => 'Interior Lapu Lapu St. Tanay Rizal',
                'created_at' => '2023-04-25 07:24:24',
                'firstname' => 'Dandre Mitchel',
                'id' => 2,
                'lastname' => 'Collera',
                'lrn' => NULL,
                'middlename' => 'Ranes',
                'mobilenumber' => '09761816840',
                'photo' => '2.jpg',
                'strand' => NULL,
                'updated_at' => '2023-04-25 07:24:24',
                'userid' => 2,
                'yearlevel' => NULL,
            ),
            2 => 
            array (
                'address' => '',
                'created_at' => '2023-04-25 07:25:02',
                'firstname' => 'Jaymielyn',
                'id' => 3,
                'lastname' => 'Cruz',
                'lrn' => NULL,
                'middlename' => '',
                'mobilenumber' => '',
                'photo' => '3.jpg',
                'strand' => NULL,
                'updated_at' => '2023-04-25 07:25:02',
                'userid' => 3,
                'yearlevel' => NULL,
            ),
            3 => 
            array (
                'address' => '',
                'created_at' => '2023-04-25 07:25:38',
                'firstname' => 'Ralph Vincent',
                'id' => 4,
                'lastname' => 'Extra',
                'lrn' => NULL,
                'middlename' => '',
                'mobilenumber' => '',
                'photo' => '4.jpg',
                'strand' => NULL,
                'updated_at' => '2023-04-25 07:25:38',
                'userid' => 4,
                'yearlevel' => NULL,
            ),
            4 => 
            array (
                'address' => '',
                'created_at' => '2023-04-25 07:28:29',
                'firstname' => 'Al Valle',
                'id' => 5,
                'lastname' => 'Apostadero',
                'lrn' => NULL,
                'middlename' => '',
                'mobilenumber' => '',
                'photo' => '5.jpg',
                'strand' => NULL,
                'updated_at' => '2023-04-25 07:28:29',
                'userid' => 5,
                'yearlevel' => NULL,
            ),
            5 => 
            array (
                'address' => '4fdsafasdgasfdasd',
                'created_at' => '2023-11-05 09:55:19',
                'firstname' => 'Test',
                'id' => 6,
                'lastname' => 'Teacher4',
                'lrn' => NULL,
                'middlename' => '',
                'mobilenumber' => '42342134124',
                'photo' => '6.jpg',
                'strand' => NULL,
                'updated_at' => '2023-11-05 09:55:19',
                'userid' => 6,
                'yearlevel' => NULL,
            ),
        ));
        
        
    }
}