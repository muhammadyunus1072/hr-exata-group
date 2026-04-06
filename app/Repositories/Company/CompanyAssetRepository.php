<?php

namespace App\Repositories\Company;

use App\Models\Company\CompanyAsset;
use App\Repositories\MasterDataRepository;

class CompanyAssetRepository extends MasterDataRepository
{
    protected static function className(): string
    {
        return CompanyAsset::class;
    }

    public static function datatable()
    {
        return CompanyAsset::query();
    }
}
