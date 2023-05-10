<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(MainUsersTableSeeder::class);
        $this->call(MainUsersDetailsTableSeeder::class);
        $this->call(AppointmentsTableSeeder::class);
        $this->call(GradesTableSeeder::class);
        $this->call(SchedulesTableSeeder::class);
        $this->call(SchoolyearsTableSeeder::class);
        $this->call(SectionsTableSeeder::class);
        $this->call(StudentsTableSeeder::class);
        $this->call(SubjectsTableSeeder::class);
        $this->call(TeachersTableSeeder::class);
        $this->call(TuitionTableSeeder::class);
    }
}
