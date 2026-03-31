<?php

namespace App\Repositories\Employee;

use App\Models\Employee\EmployeeHobby;
use App\Repositories\MasterDataRepository;

class EmployeeHobbyRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return EmployeeHobby::class;
    }

    public static function datatable()
    {
        return EmployeeHobby::query();
    }
}
