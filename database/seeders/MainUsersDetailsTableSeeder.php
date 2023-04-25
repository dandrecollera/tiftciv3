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
                'firstname' => 'Dandre Mitchel',
                'middlename' => 'Ranes',
                'lastname' => 'Collera',
                'mobilenumber' => '12345678912',
                'address' => 'Interior Lapu Lapu St. Brgy. Kaybuto Tanay, Rizal',
                'photo' => 'code12.png',
                'created_at' => '2023-04-23 18:19:09',
                'updated_at' => '2023-04-23 18:19:09',
            ),
            1 => 
            array (
                'id' => 2,
                'userid' => 2,
                'firstname' => 'Edit Admin',
                'middlename' => '',
                'lastname' => 'Test',
                'mobilenumber' => '12345678912',
                'address' => 'Edit this Admin',
                'photo' => 'note.png',
                'created_at' => '2023-04-25 07:24:24',
                'updated_at' => '2023-04-25 07:24:24',
            ),
            2 => 
            array (
                'id' => 3,
                'userid' => 3,
                'firstname' => 'Delete Admin',
                'middlename' => 'Please',
                'lastname' => 'Delete',
                'mobilenumber' => '12345678912',
                'address' => 'Delete This Admin',
                'photo' => 'note.png',
                'created_at' => '2023-04-25 07:25:02',
                'updated_at' => '2023-04-25 07:25:02',
            ),
            3 => 
            array (
                'id' => 4,
                'userid' => 4,
                'firstname' => 'Dandre Mitchel',
                'middlename' => 'Ranes',
                'lastname' => 'Collera',
                'mobilenumber' => '12345678912',
                'address' => 'Main Teacher',
                'photo' => 'azurinez.png',
                'created_at' => '2023-04-25 07:25:38',
                'updated_at' => '2023-04-25 07:25:38',
            ),
            4 => 
            array (
                'id' => 5,
                'userid' => 5,
                'firstname' => 'Edit Teacher',
                'middlename' => '',
                'lastname' => 'Test',
                'mobilenumber' => '12345678912',
                'address' => 'Edit Teacher',
                'photo' => 'note.png',
                'created_at' => '2023-04-25 07:28:29',
                'updated_at' => '2023-04-25 07:28:29',
            ),
            5 => 
            array (
                'id' => 6,
                'userid' => 6,
                'firstname' => 'Delete Teacher',
                'middlename' => '',
                'lastname' => 'Test',
                'mobilenumber' => '12345678912',
                'address' => 'Delete Teacher',
                'photo' => 'note.png',
                'created_at' => '2023-04-25 07:28:54',
                'updated_at' => '2023-04-25 07:28:54',
            ),
        ));
        
        
    }
}