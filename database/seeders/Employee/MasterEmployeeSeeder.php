<?php

namespace Database\Seeders\Employee;

use App\Imports\ImportMasterUser;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class MasterEmployeeSeeder extends Seeder
{
    public function run(): void
    {
        Excel::import(
            new ImportMasterUser(),
            storage_path('app/seeders/employee.xlsx')
        );
    }
}
