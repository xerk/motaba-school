<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;
use App\Configs\ClassEdu;

class AddExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $browes = Voyager::canOrFail('browse_add_expenses');
        return view('vendor.voyager.expenses.add-expenses');
    }

    public function getAddExpenses(Request $request) {
        $classEdu = ClassEdu::all();

        return [
            'classEdu' => $classEdu,
        ];
    }
}
