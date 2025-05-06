<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = ['HR', 'Finance', 'IT', 'Marketing', 'Sales', 'Support', 'Legal', 'Admin', 'QA', 'DevOps'];
        foreach ($departments as $dept) {
            Department::create([
                'name' => $dept,
                'description' => "$dept Department"
            ]);
        }
    }
}
