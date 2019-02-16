<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\User;
use Carbon\Carbon;
use App\Lecture;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $browes = Voyager::canOrFail('browse_attendances');
        return view('vendor.voyager.attendances.attendances');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->classRoom != '') {
            $date = Carbon::now()->addDays($request->day);
            $count = Attendance::where(function($query) use ($date, $request) {
                $query->where('attend_date', $date->toDateString())->whereHas('users', function ($q) use ($request) {
                    $q->where('job', '=', 1);
                    $q->where('classroom_id', '=', $request->classRoom);
                });
            })->count();

            $attends = User::where(function($query) use ($request) {
                    $query->where('classroom_id', '=', $request->classRoom)
                        ->where('job', '=', 1);
                })->get();

            $attendCount = $attends->count();
            // dd($attendCount);

            if ($count == 0) {
                if ($attendCount > 0) {
                    // Right Post Command
                    if ($date->toDateString() <= Carbon::now()) {
                        foreach ($attends as $key => $attend) {
                            Attendance::create([
                                'user_id'   => $attend->id,
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
                return 'You already added student!';
            }
        } else {
            return 'Please Choose the display student.';
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

    public function getStudents(Request $request)
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
