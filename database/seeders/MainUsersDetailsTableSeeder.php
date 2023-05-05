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
                'address' => 'Interior Lapu Lapu St. Brgy. Kaybuto Tanay, Rizal',
                'created_at' => '2023-04-23 18:19:09',
                'firstname' => 'Dandre Mitchel',
                'id' => 1,
                'lastname' => 'Collera',
                'middlename' => 'Ranes',
                'mobilenumber' => '12345678912',
                'photo' => 'code12.png',
                'updated_at' => '2023-04-23 18:19:09',
                'userid' => 1,
            ),
            1 => 
            array (
                'address' => 'Edit this Admin',
                'created_at' => '2023-04-25 07:24:24',
                'firstname' => 'Edit Admin',
                'id' => 2,
                'lastname' => 'Test',
                'middlename' => '',
                'mobilenumber' => '12345678912',
                'photo' => 'note.png',
                'updated_at' => '2023-04-25 07:24:24',
                'userid' => 2,
            ),
            2 => 
            array (
                'address' => 'Delete This Admin',
                'created_at' => '2023-04-25 07:25:02',
                'firstname' => 'Delete Admin',
                'id' => 3,
                'lastname' => 'Delete',
                'middlename' => 'Please',
                'mobilenumber' => '12345678912',
                'photo' => 'note.png',
                'updated_at' => '2023-04-25 07:25:02',
                'userid' => 3,
            ),
            3 => 
            array (
                'address' => 'Main Teacher',
                'created_at' => '2023-04-25 07:25:38',
                'firstname' => 'Dandre Mitchel',
                'id' => 4,
                'lastname' => 'Collera',
                'middlename' => 'Ranes',
                'mobilenumber' => '12345678912',
                'photo' => 'azurinez.png',
                'updated_at' => '2023-04-25 07:25:38',
                'userid' => 4,
            ),
            4 => 
            array (
                'address' => 'Edit Teacher',
                'created_at' => '2023-04-25 07:28:29',
                'firstname' => 'Edit Teacher',
                'id' => 5,
                'lastname' => 'Test',
                'middlename' => '',
                'mobilenumber' => '12345678912',
                'photo' => 'note.png',
                'updated_at' => '2023-04-25 07:28:29',
                'userid' => 5,
            ),
            5 => 
            array (
                'address' => 'Delete Teacher',
                'created_at' => '2023-04-25 07:28:54',
                'firstname' => 'Delete Teacher',
                'id' => 6,
                'lastname' => 'Test',
                'middlename' => '',
                'mobilenumber' => '12345678912',
                'photo' => 'note.png',
                'updated_at' => '2023-04-25 07:28:54',
                'userid' => 6,
            ),
            6 => 
            array (
                'address' => 'student 1 address',
                'created_at' => '2023-05-04 18:50:48',
                'firstname' => 'Student',
                'id' => 7,
                'lastname' => 'TheOne',
                'middlename' => 'One',
                'mobilenumber' => '12345678912',
                'photo' => 'hbd.png',
                'updated_at' => '2023-05-04 18:50:48',
                'userid' => 7,
            ),
            7 => 
            array (
                'address' => 'student2',
                'created_at' => '2023-05-04 19:12:15',
                'firstname' => 'Student',
                'id' => 8,
                'lastname' => 'Two',
                'middlename' => '',
                'mobilenumber' => '12345678912',
                'photo' => 'azurinez.png',
                'updated_at' => '2023-05-04 19:12:15',
                'userid' => 8,
            ),
            8 => 
            array (
                'address' => 'Student 3',
                'created_at' => '2023-05-04 19:13:51',
                'firstname' => 'Student',
                'id' => 9,
                'lastname' => 'Three',
                'middlename' => '',
                'mobilenumber' => '12345678912',
                'photo' => 'code12.png',
                'updated_at' => '2023-05-04 19:13:51',
                'userid' => 9,
            ),
            9 => 
            array (
                'address' => 'Teacher 3',
                'created_at' => '2023-05-05 05:54:31',
                'firstname' => 'Teacher',
                'id' => 10,
                'lastname' => 'Three',
                'middlename' => '',
                'mobilenumber' => '12345678912',
                'photo' => '3d523b98f20683c0d08d867fa8a72009.png',
                'updated_at' => '2023-05-05 05:54:31',
                'userid' => 10,
            ),
            10 => 
            array (
                'address' => 'Teacher 5',
                'created_at' => '2023-05-05 05:54:54',
                'firstname' => 'Teacher',
                'id' => 11,
                'lastname' => 'Five',
                'middlename' => '',
                'mobilenumber' => '12345678912',
                'photo' => 'azurinez.png',
                'updated_at' => '2023-05-05 05:54:54',
                'userid' => 11,
            ),
        ));
        
        
    }
}