<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('app.employee.employee.index');
    }

    public function create()
    {
        return view('app.employee.employee.detail', ["objId" => null]);
    }

    public function edit(Request $request)
    {
        return view('app.employee.employee.detail', ["objId" => $request->id]);
    }
}
