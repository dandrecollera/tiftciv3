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
                'code' => 'ENG1',
                'created_at' => NULL,
                'description' => 'English Reading and Writing',
                'id' => 1,
                'status' => 'active',
                'subject_name' => 'Reading and Writing',
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'code' => 'FIL1',
                'created_at' => NULL,
                'description' => 'Filipino Research',
                'id' => 2,
                'status' => 'active',
                'subject_name' => 'Pagbabasa at Pagsusuri ng Iba\'t ibang Teksto Tungo sa Pananaliksik',
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'code' => 'STAT1',
                'created_at' => NULL,
                'description' => 'Statistic Math',
                'id' => 3,
                'status' => 'active',
                'subject_name' => 'Statistic and Probability',
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'code' => 'SCI1',
                'created_at' => NULL,
                'description' => 'Physical Science Subject',
                'id' => 4,
                'status' => 'active',
                'subject_name' => 'Physical Science',
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'code' => 'PHL1',
                'created_at' => NULL,
                'description' => 'Philosopy Subject',
                'id' => 5,
                'status' => 'active',
                'subject_name' => 'Introduction to the Philosophy of the Human Person',
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'code' => 'PE2',
                'created_at' => NULL,
                'description' => 'Basic PE',
                'id' => 6,
                'status' => 'active',
                'subject_name' => 'Physical Education and Health 2',
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'code' => 'RESEARCH',
                'created_at' => NULL,
                'description' => 'Practical Research',
                'id' => 7,
                'status' => 'active',
                'subject_name' => 'Practical Research',
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'code' => 'MAR',
                'created_at' => NULL,
                'description' => 'Marketing',
                'id' => 8,
                'status' => 'active',
                'subject_name' => 'Principle Of Marketing',
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'code' => 'ABM1',
                'created_at' => NULL,
                'description' => 'ABM1 Subject',
                'id' => 9,
                'status' => 'active',
                'subject_name' => 'Fundamentals of Accountancy, Business, and Management 1',
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'code' => 'FBNC2',
                'created_at' => NULL,
                'description' => 'Food and Beverage',
                'id' => 10,
                'status' => 'active',
            'subject_name' => 'Food and Beverage Services (NCII)',
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'code' => 'BPNC2',
                'created_at' => NULL,
                'description' => 'Bread and Pastry',
                'id' => 11,
                'status' => 'active',
            'subject_name' => 'Bread and Pastry Production (NCII)',
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'code' => 'CSSNC2',
                'created_at' => NULL,
                'description' => 'Computer System Servicing',
                'id' => 12,
                'status' => 'active',
            'subject_name' => 'Computer System Servicing (NCII)',
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'code' => 'PE4',
                'created_at' => NULL,
                'description' => 'PE4 Basic PE',
                'id' => 13,
                'status' => 'active',
                'subject_name' => 'Physical Education Health 4',
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'code' => 'ENT',
                'created_at' => NULL,
                'description' => 'Entrep Subject',
                'id' => 14,
                'status' => 'active',
                'subject_name' => 'Entrepreneurship',
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'code' => 'ET',
                'created_at' => NULL,
                'description' => 'Technology Subject',
                'id' => 15,
                'status' => 'active',
                'subject_name' => 'Empowerment Technologies',
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'code' => 'FIL2',
                'created_at' => NULL,
                'description' => 'Filipino Subject',
                'id' => 16,
                'status' => 'active',
                'subject_name' => 'Filipino sa Piling Larangan',
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'code' => 'III',
                'created_at' => NULL,
                'description' => 'Immersion Subject',
                'id' => 17,
                'status' => 'active',
                'subject_name' => 'Inquiries, Investigation and Immersion',
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'code' => 'WORK',
                'created_at' => NULL,
                'description' => 'Immersion Subject Real',
                'id' => 18,
                'status' => 'active',
                'subject_name' => 'Work Immersion',
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'code' => 'ECO1',
                'created_at' => NULL,
                'description' => 'Applied Economics',
                'id' => 19,
                'status' => 'active',
                'subject_name' => 'Applied Economics',
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'code' => 'BESR',
                'created_at' => NULL,
                'description' => 'Ethics Subject',
                'id' => 20,
                'status' => 'active',
                'subject_name' => 'Business Ethics and Social Responsibility',
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'code' => 'CNC2',
                'created_at' => NULL,
                'description' => 'Cookery Subject',
                'id' => 21,
                'status' => 'active',
            'subject_name' => 'Cookery (NCII)',
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}