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
                'semester' => '1st',
                'strand' => 'GENERAL',
                'subject_name' => 'Reading and Writing',
                'updated_at' => NULL,
                'yearlevel' => '11',
            ),
            1 =>
            array (
                'created_at' => NULL,
                'id' => 3,
                'semester' => '1st',
                'strand' => 'GENERAL',
                'subject_name' => 'Pagbabasa at Pagsusuri ng Iba\'t ibang Teksto Tungo sa Pananaliksik',
                'updated_at' => NULL,
                'yearlevel' => '11',
            ),
            2 =>
            array (
                'created_at' => NULL,
                'id' => 4,
                'semester' => '1st',
                'strand' => 'GENERAL',
                'subject_name' => 'Statistic and Probability',
                'updated_at' => NULL,
                'yearlevel' => '11',
            ),
            3 =>
            array (
                'created_at' => NULL,
                'id' => 5,
                'semester' => '2nd',
                'strand' => 'GENERAL',
                'subject_name' => 'Physical Science',
                'updated_at' => NULL,
                'yearlevel' => '11',
            ),
            4 =>
            array (
                'created_at' => NULL,
                'id' => 6,
                'semester' => '1st',
                'strand' => 'GENERAL',
                'subject_name' => 'Introduction to the Philosophy of the Human Person',
                'updated_at' => NULL,
                'yearlevel' => '11',
            ),
            5 =>
            array (
                'created_at' => NULL,
                'id' => 7,
                'semester' => '1st',
                'strand' => 'GENERAL',
                'subject_name' => 'Physical Education and Health 2',
                'updated_at' => NULL,
                'yearlevel' => '11',
            ),
            6 =>
            array (
                'created_at' => NULL,
                'id' => 8,
                'semester' => '1st',
                'strand' => 'GENERAL',
                'subject_name' => 'Practical Research',
                'updated_at' => NULL,
                'yearlevel' => '11',
            ),
            7 =>
            array (
                'created_at' => NULL,
                'id' => 9,
                'semester' => '2nd',
                'strand' => 'ABM',
                'subject_name' => 'Principle Of Marketing',
                'updated_at' => NULL,
                'yearlevel' => '11',
            ),
            8 =>
            array (
                'created_at' => NULL,
                'id' => 10,
                'semester' => '2nd',
                'strand' => 'ABM',
                'subject_name' => 'Fundamentals of Accountancy, Business, and Management 1',
                'updated_at' => NULL,
                'yearlevel' => '11',
            ),
            9 =>
            array (
                'created_at' => NULL,
                'id' => 11,
                'semester' => '2nd',
                'strand' => 'HE',
            'subject_name' => 'Food and Beverage Services (NCII)',
                'updated_at' => NULL,
                'yearlevel' => '11',
            ),
            10 =>
            array (
                'created_at' => NULL,
                'id' => 12,
                'semester' => '2nd',
                'strand' => 'HE',
            'subject_name' => 'Bread and Pastry Production (NCII)',
                'updated_at' => NULL,
                'yearlevel' => '11',
            ),
            11 =>
            array (
                'created_at' => NULL,
                'id' => 13,
                'semester' => '2nd',
                'strand' => 'ICT',
            'subject_name' => 'Computer System Servicing (NCII)',
                'updated_at' => NULL,
                'yearlevel' => '11',
            ),
            12 =>
            array (
                'created_at' => NULL,
                'id' => 14,
                'semester' => '1st',
                'strand' => 'GENERAL',
                'subject_name' => 'Physical Education Health 4',
                'updated_at' => NULL,
                'yearlevel' => '12',
            ),
            13 =>
            array (
                'created_at' => NULL,
                'id' => 15,
                'semester' => '2nd',
                'strand' => 'GENERAL',
                'subject_name' => 'Entrepreneurship',
                'updated_at' => NULL,
                'yearlevel' => '12',
            ),
            14 =>
            array (
                'created_at' => NULL,
                'id' => 16,
                'semester' => '1st',
                'strand' => 'GENERAL',
                'subject_name' => 'Empowerment Technologies',
                'updated_at' => NULL,
                'yearlevel' => '12',
            ),
            15 =>
            array (
                'created_at' => NULL,
                'id' => 17,
                'semester' => '1st',
                'strand' => 'GENERAL',
                'subject_name' => 'Filipino sa Piling Larangan',
                'updated_at' => NULL,
                'yearlevel' => '12',
            ),
            16 =>
            array (
                'created_at' => NULL,
                'id' => 18,
                'semester' => '2nd',
                'strand' => 'GENERAL',
                'subject_name' => 'Inquiries, Investigation and Immersion',
                'updated_at' => NULL,
                'yearlevel' => '12',
            ),
            17 =>
            array (
                'created_at' => NULL,
                'id' => 19,
                'semester' => '2nd',
                'strand' => 'GENERAL',
                'subject_name' => 'Work Immersion',
                'updated_at' => NULL,
                'yearlevel' => '12',
            ),
            18 =>
            array (
                'created_at' => NULL,
                'id' => 20,
                'semester' => '1st',
                'strand' => 'GENERAL',
                'subject_name' => 'Applied Economics',
                'updated_at' => NULL,
                'yearlevel' => '12',
            ),
            19 =>
            array (
                'created_at' => NULL,
                'id' => 21,
                'semester' => '1st',
                'strand' => 'ABM',
                'subject_name' => 'Business Ethics and Social Responsibility',
                'updated_at' => NULL,
                'yearlevel' => '12',
            ),
            20 =>
            array (
                'created_at' => NULL,
                'id' => 22,
                'semester' => '2nd',
                'strand' => 'HE',
            'subject_name' => 'Cookery (NCII)',
                'updated_at' => NULL,
                'yearlevel' => '12',
            ),
            21 =>
            array (
                'created_at' => NULL,
                'id' => 23,
                'semester' => '2nd',
                'strand' => 'ICT',
            'subject_name' => 'Computer System Servicing (NCII)',
                'updated_at' => NULL,
                'yearlevel' => '12',
            ),
        ));


    }
}
