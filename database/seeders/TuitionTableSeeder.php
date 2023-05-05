<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TuitionTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('tuition')->delete();

        \DB::table('tuition')->insert(array (
            0 =>
            array (
                'id' => 1,
                'userid' => 7,
                'yearid' => 2,
                'paymenttype' => 'public',
                'paymentmethod' => 'full',
                'voucher' => '0.00',
                'tuition' => '0.00',
                'registration' => '0.00',
                'created_at' => '2023-05-04 18:50:48',
                'updated_at' => '2023-05-04 18:50:48',
            ),
            1 =>
            array (
                'id' => 2,
                'userid' => 8,
                'yearid' => 2,
                'paymenttype' => 'semi',
                'paymentmethod' => 'full',
                'voucher' => '0.00',
                'tuition' => '0.00',
                'registration' => '0.00',
                'created_at' => '2023-05-04 19:12:15',
                'updated_at' => '2023-05-04 19:12:15',
            ),
            2 =>
            array (
                'id' => 3,
                'userid' => 9,
                'yearid' => 2,
                'paymenttype' => 'private',
                'paymentmethod' => 'semesteral',
                'voucher' => '0.00',
                'tuition' => '17500.00',
                'registration' => '1000.00',
                'created_at' => '2023-05-04 19:13:51',
                'updated_at' => '2023-05-04 19:13:51',
            ),
        ));


    }
}
