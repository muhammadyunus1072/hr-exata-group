<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployeeCareerStatusController extends Controller
{
    public function index()
    {
        return view('app.employee.employee-career-status.index');
    }

    public function create()
    {
        return view('app.employee.employee-career-status.detail', ["objId" => null]);
    }

    public function edit(Request $request)
    {
        return view('app.employee.employee-career-status.detail', ["objId" => $request->id]);
    }
}
