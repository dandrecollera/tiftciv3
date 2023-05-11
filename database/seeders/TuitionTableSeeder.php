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
                'userid' => 6,
                'yearid' => 2,
                'paymenttype' => 'public',
                'paymentmethod' => 'full',
                'voucher' => '0.00',
                'tuition' => '0.00',
                'registration' => '0.00',
                'created_at' => '2023-05-11 04:38:50',
                'updated_at' => '2023-05-11 04:38:50',
            ),
        ));
        
        
    }
}