<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Repositories\Company\CompanyAssetRepository;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CompanyAssetController extends Controller
{
    public function index()
    {
        return view('app.company.company-asset.index');
    }

    public function create()
    {
        return view('app.company.company-asset.detail', ["objId" => null]);
    }

    public function edit(Request $request)
    {
        return view('app.company.company-asset.detail', ["objId" => $request->id]);
    }

    public function generate_qr(Request $request)
    {
        try {
            $transaction = CompanyAssetRepository::findBy([
                ['id', Crypt::decrypt($request->id)]
            ]);
            $qrCode = QrCode::size(400)->generate($transaction->id);

            return $qrCode;
            return view('app.service.generate-qr.index', ["qrCode" => $qrCode, "code" => $transaction->booking_code]);
        } catch (DecryptException $e) {
            return redirect()->route('public.index');
        }
    }
}
