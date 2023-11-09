<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CurriculumsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('curriculums')->delete();

        \DB::table('curriculums')->insert(array (
        ));


    }
}
