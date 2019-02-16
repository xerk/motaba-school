<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Support\Facades\DB;

class SingleStudentReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $browes = Voyager::canOrFail('browse_single_student_report');
        return view('vendor.voyager.reports.single-student-report');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $date = Carbon::now()->addMonth($request->month)->toDateString();
        $user = User::with('attendance')->whereHas('attendance', function ($query) use($request) {
            $now = Carbon::now();
            $query->whereRaw('extract(month from attend_date) = ?', [$now->addMonth($request->month)->month]);
        })->where('id', $request->id)
        ->withCount(['attendance as count_attend' => function ($query) use($request) {
            $now = Carbon::now();
            $query->whereRaw('extract(month from attend_date) = ?', [$now->addMonth($request->month)->month])->where('status', 1);
        }])
        ->withCount(['attendance as count_holiday' => function ($query) use($request) {
            $now = Carbon::now();
            $query->whereRaw('extract(month from attend_date) = ?', [$now->addMonth($request->month)->month])->where('status', 2);
        }])
        ->withCount(['attendance as count_absent' => function ($query) use($request) {
            $now = Carbon::now();
            $query->whereRaw('extract(month from attend_date) = ?', [$now->addMonth($request->month)->month])->where('status', 3);
        }])
        ->first();

        $attendance = User::with(['attendance' => function ($query) use($request) {
            $now = Carbon::now();
            $query->whereRaw('extract(month from attend_date) = ?', [$now->addMonth($request->month)->month])->where('status', 3);
        }])->whereHas('attendance', function ($query) use($request) {
            $now = Carbon::now();
            $query->whereRaw('extract(month from attend_date) = ?', [$now->addMonth($request->month)->month])->where('status', 3);
        })->where('id', $request->id)->first();

        $expenses = User::where('id', $request->id)->with('expenses', 'classEdu')
            ->withCount(['expenses AS paySum' => function ($query) {
                $query->select(DB::raw("SUM(pay) as paySum"));
            }])
            ->withCount(['expenses AS costSum' => function ($query) {
                $query->select(DB::raw("SUM(cost) as costSum"));
            }])
            ->withCount(['expenses AS discountSum' => function ($query) {
                $query->select(DB::raw("SUM(discount) as discountSum"));
            }])
            ->first();

        return [
            'user' => $user,
            'date' => $date,
            'attendance' => $attendance,
            'expenses' => $expenses,
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getStudent()
    {
        $users = User::with('classEdu')->where('job', 1)->get();

        return [
            'users' => $users,
        ];
    }


}
