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
                'accounttype' => 'admin',
                'created_at' => '2023-04-23 18:18:31',
                'email' => 'mainadmin@admin.com',
                'id' => 1,
                'password' => '0192023a7bbd73250516f069df18b500',
                'status' => 'active',
                'updated_at' => '2023-04-23 18:18:31',
            ),
            1 => 
            array (
                'accounttype' => 'admin',
                'created_at' => '2023-04-25 07:24:24',
                'email' => 'admin1@admin.com',
                'id' => 2,
                'password' => '0192023a7bbd73250516f069df18b500',
                'status' => 'active',
                'updated_at' => '2023-04-25 07:24:24',
            ),
            2 => 
            array (
                'accounttype' => 'admin',
                'created_at' => '2023-04-25 07:25:02',
                'email' => 'admin2@admin.com',
                'id' => 3,
                'password' => '0192023a7bbd73250516f069df18b500',
                'status' => 'active',
                'updated_at' => '2023-04-25 07:25:02',
            ),
            3 => 
            array (
                'accounttype' => 'teacher',
                'created_at' => '2023-04-25 07:25:38',
                'email' => 'mainteacher@teacher.com',
                'id' => 4,
                'password' => 'a426dcf72ba25d046591f81a5495eab7',
                'status' => 'active',
                'updated_at' => '2023-04-25 07:25:38',
            ),
            4 => 
            array (
                'accounttype' => 'teacher',
                'created_at' => '2023-04-25 07:28:29',
                'email' => 'teacher1@teacher.com',
                'id' => 5,
                'password' => 'a426dcf72ba25d046591f81a5495eab7',
                'status' => 'active',
                'updated_at' => '2023-04-25 07:28:29',
            ),
            5 => 
            array (
                'accounttype' => 'teacher',
                'created_at' => '2023-04-25 07:28:54',
                'email' => 'teacher2@teacher.com',
                'id' => 6,
                'password' => 'a426dcf72ba25d046591f81a5495eab7',
                'status' => 'active',
                'updated_at' => '2023-04-25 07:28:54',
            ),
            6 => 
            array (
                'accounttype' => 'student',
                'created_at' => '2023-05-04 18:50:48',
                'email' => 'student1@student.com',
                'id' => 7,
                'password' => 'ad6a280417a0f533d8b670c61667e1a0',
                'status' => 'active',
                'updated_at' => '2023-05-04 18:50:48',
            ),
            7 => 
            array (
                'accounttype' => 'student',
                'created_at' => '2023-05-04 19:12:15',
                'email' => 'student2@student.com',
                'id' => 8,
                'password' => '213ee683360d88249109c2f92789dbc3',
                'status' => 'active',
                'updated_at' => '2023-05-04 19:12:15',
            ),
            8 => 
            array (
                'accounttype' => 'student',
                'created_at' => '2023-05-04 19:13:51',
                'email' => 'student3@student.com',
                'id' => 9,
                'password' => 'ad6a280417a0f533d8b670c61667e1a0',
                'status' => 'active',
                'updated_at' => '2023-05-04 19:13:51',
            ),
            9 => 
            array (
                'accounttype' => 'teacher',
                'created_at' => '2023-05-05 05:54:31',
                'email' => 'teacher3@teacher.com',
                'id' => 10,
                'password' => 'a426dcf72ba25d046591f81a5495eab7',
                'status' => 'active',
                'updated_at' => '2023-05-05 05:54:31',
            ),
            10 => 
            array (
                'accounttype' => 'teacher',
                'created_at' => '2023-05-05 05:54:54',
                'email' => 'teacher5@teacher.com',
                'id' => 11,
                'password' => 'a426dcf72ba25d046591f81a5495eab7',
                'status' => 'active',
                'updated_at' => '2023-05-05 05:54:54',
            ),
        ));
        
        
    }
}