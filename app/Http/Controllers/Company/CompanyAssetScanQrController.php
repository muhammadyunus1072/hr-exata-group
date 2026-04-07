<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Repositories\Company\CompanyAssetRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CompanyAssetScanQrController extends Controller
{
    public function index()
    {
        return view('app.company.company-asset-scan-qr.scanner.index');
    }

    public function create(Request $request)
    {

        $asset = CompanyAssetRepository::findBy([
            ['id', Crypt::decrypt($request->id)]
        ]);
        $qrCode = QrCode::size(400)->generate($request->id);
        return view('app.company.company-asset-scan-qr.generate.index', [
            "qrCode" => $qrCode,
            "code" => $request->id,
        ]);
    }

    public function edit(Request $request)
    {
        return view('app.company.company-asset-scan-qr.detail', ["objId" => $request->id]);
    }
}
