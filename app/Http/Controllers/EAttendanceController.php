<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\User;
use Carbon\Carbon;
use App\Lecture;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Http\Request;
use App\EmployeeSalary;

class EAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $browes = Voyager::canOrFail('browse_eattendances');
        return view('vendor.voyager.attendances.e-attendances');
    }

    public function store(Request $request)
    {
            $date = Carbon::now()->addDays($request->day);

            $count = Attendance::where(function($query) use ($date) {
                $query->where('attend_date', $date->toDateString())->whereHas('users', function ($q) {
                    $q->where('job', '=', 0);
                });
            })->count();

            $attend = User::where('job', 0)->get();

            $attendCount = $attend->count();
            // dd($attendCount);

            if ($count == 0) {
                if ($attendCount > 0) {
                    // Right Post Command
                    if ($date->toDateString() <= Carbon::now()) {
                        foreach ($attend as $key => $item) {
                            $attendId = Attendance::create([
                                'user_id'   => $item->id,
                                'attend_date' => $date->toDateString(),
                                'status' => $request->status,
                            ]);
                        }
                        return 'Item\'s has beend added!';

                    } else {
                        return 'Can\'t add the next date of day.';
                    }
                } else {
                    return 'Member is empty!';
                }
            } else {
                return 'You already added Employee!';
            }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        $attendance = Attendance::find($request->id);

        $attendance->status = $request->status;
        $attendance->save();

        return response('Attendance has been updated!', 200);
    }

    public function getEmployees(Request $request)
    {
        // dd($request->all());
        $date = Carbon::now()->addDays($request->day);
        $dateString = $date->toDateString();
        $attendances = Attendance::where('attend_date', $date->toDateString())->with('users', 'lectures')->get();
        $lectures = Lecture::all();
        // dd($date);
        return [
            'attendances' => $attendances,
            'lectures' => $lectures,
            'date' => $dateString
        ];
    }
}
