<?php

namespace App\Repositories\Employee;

use App\Models\Employee\EmployeeDrink;
use App\Repositories\MasterDataRepository;

class EmployeeDrinkRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return EmployeeDrink::class;
    }

    public static function datatable()
    {
        return EmployeeDrink::query();
    }
}
