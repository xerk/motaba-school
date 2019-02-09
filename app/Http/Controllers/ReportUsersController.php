<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ReportUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return User::with('classEdu', 'classRoom')->where(function ($query) use($request) {
            $query->where('classroom_id', $request->classroom)->where('job', '1');
        })->first();
    }

}
