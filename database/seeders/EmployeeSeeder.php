<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\EmployeeDetail;
use App\Models\Department;
use Illuminate\Support\Str;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $departmentIds = Department::pluck('id')->toArray();

        foreach (range(1, 100) as $i) {
            foreach (range(1, 1000) as $j) {
                $id = Str::uuid()->toString();

                $employee = Employee::create([
                    'id' => $id,
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'department_id' => $faker->randomElement($departmentIds),
                ]);

                $employee->detail()->create([
                    'designation' => $faker->jobTitle,
                    'salary' => $faker->numberBetween(40000, 150000),
                    'address' => $faker->address,
                    'joined_date' => $faker->date(),
                ]);
            }
        }
    }
}
