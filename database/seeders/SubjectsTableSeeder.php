<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SubjectsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('subjects')->delete();
        
        \DB::table('subjects')->insert(array (
            0 => 
            array (
                'created_at' => NULL,
                'id' => 2,
                'status' => 'active',
                'subject_name' => 'Reading and Writing',
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'created_at' => NULL,
                'id' => 3,
                'status' => 'active',
                'subject_name' => 'Pagbabasa at Pagsusuri ng Iba\'t ibang Teksto Tungo sa Pananaliksik',
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'created_at' => NULL,
                'id' => 4,
                'status' => 'active',
                'subject_name' => 'Statistic and Probability',
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'created_at' => NULL,
                'id' => 5,
                'status' => 'active',
                'subject_name' => 'Physical Science',
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'created_at' => NULL,
                'id' => 6,
                'status' => 'active',
                'subject_name' => 'Introduction to the Philosophy of the Human Person',
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'created_at' => NULL,
                'id' => 7,
                'status' => 'active',
                'subject_name' => 'Physical Education and Health 2',
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'created_at' => NULL,
                'id' => 8,
                'status' => 'active',
                'subject_name' => 'Practical Research',
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'created_at' => NULL,
                'id' => 9,
                'status' => 'active',
                'subject_name' => 'Principle Of Marketing',
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'created_at' => NULL,
                'id' => 10,
                'status' => 'active',
                'subject_name' => 'Fundamentals of Accountancy, Business, and Management 1',
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'created_at' => NULL,
                'id' => 11,
                'status' => 'active',
            'subject_name' => 'Food and Beverage Services (NCII)',
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'created_at' => NULL,
                'id' => 12,
                'status' => 'active',
            'subject_name' => 'Bread and Pastry Production (NCII)',
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'created_at' => NULL,
                'id' => 13,
                'status' => 'active',
            'subject_name' => 'Computer System Servicing (NCII)',
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'created_at' => NULL,
                'id' => 14,
                'status' => 'active',
                'subject_name' => 'Physical Education Health 4',
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'created_at' => NULL,
                'id' => 15,
                'status' => 'active',
                'subject_name' => 'Entrepreneurship',
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'created_at' => NULL,
                'id' => 16,
                'status' => 'active',
                'subject_name' => 'Empowerment Technologies',
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'created_at' => NULL,
                'id' => 17,
                'status' => 'active',
                'subject_name' => 'Filipino sa Piling Larangan',
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'created_at' => NULL,
                'id' => 18,
                'status' => 'active',
                'subject_name' => 'Inquiries, Investigation and Immersion',
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'created_at' => NULL,
                'id' => 19,
                'status' => 'active',
                'subject_name' => 'Work Immersion',
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'created_at' => NULL,
                'id' => 20,
                'status' => 'active',
                'subject_name' => 'Applied Economics',
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'created_at' => NULL,
                'id' => 21,
                'status' => 'active',
                'subject_name' => 'Business Ethics and Social Responsibility',
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'created_at' => NULL,
                'id' => 22,
                'status' => 'active',
            'subject_name' => 'Cookery (NCII)',
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'created_at' => NULL,
                'id' => 23,
                'status' => 'active',
            'subject_name' => 'Computer System Servicing (NCII)',
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'created_at' => '2023-10-24 11:29:06',
                'id' => 24,
                'status' => 'inactive',
                'subject_name' => 'test',
                'updated_at' => '2023-10-24 11:29:06',
            ),
        ));
        
        
    }
}