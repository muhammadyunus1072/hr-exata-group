<?php

namespace App\Repositories\Employee;

use App\Models\Employee\EmployeeFood;
use App\Repositories\MasterDataRepository;

class EmployeeFoodRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return EmployeeFood::class;
    }

    public static function datatable()
    {
        return EmployeeFood::query();
    }
}
