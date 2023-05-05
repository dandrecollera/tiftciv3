<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MainUsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('main_users')->delete();
        
        \DB::table('main_users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'email' => 'mainadmin@admin.com',
                'password' => '0192023a7bbd73250516f069df18b500',
                'accounttype' => 'admin',
                'status' => 'active',
                'created_at' => '2023-04-23 18:18:31',
                'updated_at' => '2023-04-23 18:18:31',
            ),
            1 => 
            array (
                'id' => 2,
                'email' => 'admin1@admin.com',
                'password' => '0192023a7bbd73250516f069df18b500',
                'accounttype' => 'admin',
                'status' => 'active',
                'created_at' => '2023-04-25 07:24:24',
                'updated_at' => '2023-04-25 07:24:24',
            ),
            2 => 
            array (
                'id' => 3,
                'email' => 'admin2@admin.com',
                'password' => '0192023a7bbd73250516f069df18b500',
                'accounttype' => 'admin',
                'status' => 'active',
                'created_at' => '2023-04-25 07:25:02',
                'updated_at' => '2023-04-25 07:25:02',
            ),
            3 => 
            array (
                'id' => 4,
                'email' => 'mainteacher@teacher.com',
                'password' => 'a426dcf72ba25d046591f81a5495eab7',
                'accounttype' => 'teacher',
                'status' => 'active',
                'created_at' => '2023-04-25 07:25:38',
                'updated_at' => '2023-04-25 07:25:38',
            ),
            4 => 
            array (
                'id' => 5,
                'email' => 'teacher1@teacher.com',
                'password' => 'a426dcf72ba25d046591f81a5495eab7',
                'accounttype' => 'teacher',
                'status' => 'active',
                'created_at' => '2023-04-25 07:28:29',
                'updated_at' => '2023-04-25 07:28:29',
            ),
            5 => 
            array (
                'id' => 6,
                'email' => 'teacher2@teacher.com',
                'password' => 'a426dcf72ba25d046591f81a5495eab7',
                'accounttype' => 'teacher',
                'status' => 'active',
                'created_at' => '2023-04-25 07:28:54',
                'updated_at' => '2023-04-25 07:28:54',
            ),
            6 => 
            array (
                'id' => 7,
                'email' => 'student1@student.com',
                'password' => 'ad6a280417a0f533d8b670c61667e1a0',
                'accounttype' => 'student',
                'status' => 'active',
                'created_at' => '2023-05-04 18:50:48',
                'updated_at' => '2023-05-04 18:50:48',
            ),
            7 => 
            array (
                'id' => 8,
                'email' => 'student2@student.com',
                'password' => '213ee683360d88249109c2f92789dbc3',
                'accounttype' => 'student',
                'status' => 'active',
                'created_at' => '2023-05-04 19:12:15',
                'updated_at' => '2023-05-04 19:12:15',
            ),
            8 => 
            array (
                'id' => 9,
                'email' => 'student3@student.com',
                'password' => 'ad6a280417a0f533d8b670c61667e1a0',
                'accounttype' => 'student',
                'status' => 'active',
                'created_at' => '2023-05-04 19:13:51',
                'updated_at' => '2023-05-04 19:13:51',
            ),
        ));
        
        
    }
}