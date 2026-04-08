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

    public static function datatable($jenis)
    {
        return CompanyAsset::when($jenis, function ($query) use ($jenis) {
            $query->where('jenis', $jenis);
        });
    }
}
