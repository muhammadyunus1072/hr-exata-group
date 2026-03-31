<?php

namespace App\Repositories\Employee;

use App\Models\Employee\EmployeeOfficeEmail;
use App\Repositories\MasterDataRepository;

class EmployeeOfficeEmailRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return EmployeeOfficeEmail::class;
    }

    public static function datatable()
    {
        return EmployeeOfficeEmail::query();
    }
}
