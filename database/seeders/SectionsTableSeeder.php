<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SectionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sections')->delete();
        
        \DB::table('sections')->insert(array (
            0 => 
            array (
                'id' => 1,
                'section_name' => 'ICT 1',
                'strand' => 'ICT',
                'yearlevel' => '11',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'section_name' => 'ICT 1',
                'strand' => 'ICT',
                'yearlevel' => '12',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'section_name' => 'ICT 2',
                'strand' => 'ICT',
                'yearlevel' => '11',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'section_name' => 'ICT 2',
                'strand' => 'ICT',
                'yearlevel' => '12',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'section_name' => 'ICT 3',
                'strand' => 'ICT',
                'yearlevel' => '11',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'section_name' => 'ICT 3',
                'strand' => 'ICT',
                'yearlevel' => '12',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'section_name' => 'ICT 4',
                'strand' => 'ICT',
                'yearlevel' => '11',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'section_name' => 'ICT 5',
                'strand' => 'ICT',
                'yearlevel' => '12',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'section_name' => 'ABM 1',
                'strand' => 'ABM',
                'yearlevel' => '11',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'section_name' => 'ABM 1',
                'strand' => 'ABM',
                'yearlevel' => '12',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'section_name' => 'ABM 2',
                'strand' => 'ABM',
                'yearlevel' => '11',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'section_name' => 'ABM 2',
                'strand' => 'ABM',
                'yearlevel' => '12',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'section_name' => 'ABM 3',
                'strand' => 'ABM',
                'yearlevel' => '11',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'section_name' => 'ABM 3',
                'strand' => 'ABM',
                'yearlevel' => '12',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'section_name' => 'GAS 1',
                'strand' => 'GAS',
                'yearlevel' => '11',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'section_name' => 'GAS 1',
                'strand' => 'GAS',
                'yearlevel' => '12',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'section_name' => 'GAS 2',
                'strand' => 'GAS',
                'yearlevel' => '11',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'section_name' => 'GAS 2',
                'strand' => 'GAS',
                'yearlevel' => '12',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'section_name' => 'HE 1',
                'strand' => 'HE',
                'yearlevel' => '11',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'section_name' => 'HE 1',
                'strand' => 'HE',
                'yearlevel' => '12',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'section_name' => 'HE 2',
                'strand' => 'HE',
                'yearlevel' => '11',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'section_name' => 'HE 2',
                'strand' => 'HE',
                'yearlevel' => '12',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}