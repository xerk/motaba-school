<?php

namespace App\Http\Controllers;

use App\Timetable;
use App\Configs\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exams = Exam::all();

        return view('vendor.frontend.account.profile', [
            'exams' => $exams
        ]);
    }
}
