<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function students()
    {
        return view('vendor.voyager.reports.students');
    }
}
