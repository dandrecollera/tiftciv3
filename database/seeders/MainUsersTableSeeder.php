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
                'email' => 'masteradmin@tiftci.org',
                'password' => 'c8550856c4834da6c1ca3251f5fe264f',
                'accounttype' => 'admin',
                'status' => 'active',
                'created_at' => '2023-04-23 18:18:31',
                'updated_at' => '2023-04-23 18:18:31',
            ),
            1 =>
            array (
                'id' => 2,
                'email' => 'dandrecollera-admin@tiftci.org',
                'password' => '5f1e0eb76cb20a0da22764ca38ecc978',
                'accounttype' => 'admin',
                'status' => 'active',
                'created_at' => '2023-04-25 07:24:24',
                'updated_at' => '2023-04-25 07:24:24',
            ),
            2 =>
            array (
                'id' => 3,
                'email' => 'jaymielyncruz-admin@tiftci.org',
                'password' => '0192023a7bbd73250516f069df18b500',
                'accounttype' => 'admin',
                'status' => 'active',
                'created_at' => '2023-04-25 07:25:02',
                'updated_at' => '2023-04-25 07:25:02',
            ),
            3 =>
            array (
                'id' => 4,
                'email' => 'ralphextra-admin@tiftci.org',
                'password' => '0192023a7bbd73250516f069df18b500',
                'accounttype' => 'admin',
                'status' => 'active',
                'created_at' => '2023-04-25 07:25:02',
                'updated_at' => '2023-04-25 07:25:02',
            ),
            4 =>
            array (
                'id' => 5,
                'email' => 'alapostadero-admin@tiftci.org',
                'password' => '0192023a7bbd73250516f069df18b500',
                'accounttype' => 'admin',
                'status' => 'active',
                'created_at' => '2023-04-25 07:25:02',
                'updated_at' => '2023-04-25 07:25:02',
            ),
        ));


    }
}
