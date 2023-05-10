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
                'middlename' => 'Master',
                'mobilenumber' => '12345678912',
                'photo' => '1.png',
                'updated_at' => '2023-04-23 18:19:09',
                'userid' => 1,
            ),
            1 => 
            array (
                'address' => 'Interior Lapu Lapu St. Tanay Rizal',
                'created_at' => '2023-04-25 07:24:24',
                'firstname' => 'Dandre Mitchek',
                'id' => 2,
                'lastname' => 'Collera',
                'middlename' => 'Ranes',
                'mobilenumber' => '09761816840',
                'photo' => '2.jpg',
                'updated_at' => '2023-04-25 07:24:24',
                'userid' => 2,
            ),
            2 => 
            array (
                'address' => '',
                'created_at' => '2023-04-25 07:25:02',
                'firstname' => 'Jaymielyn',
                'id' => 3,
                'lastname' => 'Cruz',
                'middlename' => '',
                'mobilenumber' => '',
                'photo' => '3.jpg',
                'updated_at' => '2023-04-25 07:25:02',
                'userid' => 3,
            ),
            3 => 
            array (
                'address' => '',
                'created_at' => '2023-04-25 07:25:38',
                'firstname' => 'Ralph Vincent',
                'id' => 4,
                'lastname' => 'Extra',
                'middlename' => '',
                'mobilenumber' => '',
                'photo' => '4.jpg',
                'updated_at' => '2023-04-25 07:25:38',
                'userid' => 4,
            ),
            4 => 
            array (
                'address' => '',
                'created_at' => '2023-04-25 07:28:29',
                'firstname' => 'Al Valle',
                'id' => 5,
                'lastname' => 'Apostadero',
                'middlename' => '',
                'mobilenumber' => '',
                'photo' => '5.jpg',
                'updated_at' => '2023-04-25 07:28:29',
                'userid' => 5,
            ),
        ));
        
        
    }
}