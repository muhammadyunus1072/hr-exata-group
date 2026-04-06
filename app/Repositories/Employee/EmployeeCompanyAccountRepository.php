<?php

namespace App\Repositories\Employee;

use App\Models\Employee\EmployeeCompanyAccount;
use App\Repositories\MasterDataRepository;

class EmployeeCompanyAccountRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return EmployeeCompanyAccount::class;
    }

    public static function datatable()
    {
        return EmployeeCompanyAccount::query();
    }
}
