<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
