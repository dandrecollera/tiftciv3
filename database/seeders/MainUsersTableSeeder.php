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
                'email' => 'masteradmin@tiftci.com',
                'id' => 1,
                'password' => 'c8550856c4834da6c1ca3251f5fe264f',
                'status' => 'active',
                'updated_at' => '2023-04-23 18:18:31',
            ),
            1 => 
            array (
                'accounttype' => 'admin',
                'created_at' => '2023-04-25 07:24:24',
                'email' => 'dandrecollera-admin@tiftci.com',
                'id' => 2,
                'password' => '5f1e0eb76cb20a0da22764ca38ecc978',
                'status' => 'active',
                'updated_at' => '2023-04-25 07:24:24',
            ),
            2 => 
            array (
                'accounttype' => 'admin',
                'created_at' => '2023-04-25 07:25:02',
                'email' => 'jaymielyncruz-admin@tiftci.com',
                'id' => 3,
                'password' => '0192023a7bbd73250516f069df18b500',
                'status' => 'active',
                'updated_at' => '2023-04-25 07:25:02',
            ),
            3 => 
            array (
                'accounttype' => 'admin',
                'created_at' => '2023-04-25 07:25:02',
                'email' => 'ralphextra-admin@tiftci.com',
                'id' => 4,
                'password' => '0192023a7bbd73250516f069df18b500',
                'status' => 'active',
                'updated_at' => '2023-04-25 07:25:02',
            ),
            4 => 
            array (
                'accounttype' => 'admin',
                'created_at' => '2023-04-25 07:25:02',
                'email' => 'alapostadero-admin@tiftci.com',
                'id' => 5,
                'password' => '0192023a7bbd73250516f069df18b500',
                'status' => 'active',
                'updated_at' => '2023-04-25 07:25:02',
            ),
        ));
        
        
    }
}