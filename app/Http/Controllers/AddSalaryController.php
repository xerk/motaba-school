<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;

class AddSalaryController extends Controller
{
    public function index()
    {
        $browes = Voyager::canOrFail('browse_add_salaries');
        return view('vendor.voyager.add-salaries.add-salaries');
    }
}
