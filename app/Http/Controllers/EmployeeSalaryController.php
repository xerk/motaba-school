<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\User;
use Carbon\Carbon;
use App\Lecture;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Http\Request;
use App\EmployeeSalary;
use App\AddSalary;
use Illuminate\Support\Facades\DB;
use App\MakePayment;

class EmployeeSalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $browes = Voyager::canOrFail('browse_employee_salaries');
        return view('vendor.voyager.employee-salaries.employee-salaries');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            MakePayment::create([
                'user_id' => $request->user_id,
                'payment_method' => $request->model['paymentMethod'],
                'net_salary' => $request->model['netSalary'],
                'payment_amount' => $request->model['paymentAmount'],
                'comment' => $request->model['comment'],
            ]);

            Storage::create([
                'value' => $request->model['paymentAmount'],
                'comment' => $request->model['comment'],
                'type' => 2,
            ]);

            return 'Item has been add!';
        } else {
            return 'You are not a method post!';
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if($request->model) {
            $attendance = Attendance::find($request->model['id']);
            $attendance->additional     = $request->model['additional'];
            $attendance->bonus          = $request->model['bonus'];
            $attendance->incentive      = $request->model['incentive'];
            $attendance->reward         = $request->model['reward'];
            $attendance->discount       = $request->model['discount'];
            $attendance->allowance      = $request->model['allowance'];
            $attendance->loan           = $request->model['loan'];
            $attendance->penalty        = $request->model['penalty'];
            $attendance->save();

            return response('Updated Attendance Salary!', 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MakePayment::where('id', $id)->delete();

        return response('Make Payment has beend deleted.', 200);
    }

    public function getEmployees() {
        $users = User::whereHas('addSalary')->get();

        return [
            'users' => $users
        ];
    }

    public function getEmployeeDetails(Request $request) {
        $now = Carbon::now();
        $date = Carbon::now()->addMonth($request->month)->toDateString();
        // dd($now->addMonth(-1)->month);
        $user = User::where(function($query) use ($request, $now) {
            $query->where('id', '=', $request->id)
                ->where('job', '=', 0);
        })->with(['attendance' => function($query) use ($request, $now) {
            $query->whereRaw('extract(month from attend_date) = ?', [$now->addMonth($request->month)->month]);
        }])->first();

        $attendCount = Attendance::where(function($query) use ($request) {
            $now = Carbon::now();
            $query->where('status', 1)->whereRaw('extract(month from attend_date) = ?', [$now->addMonth($request->month)->month]);
        })->whereHas('users', function($query) use ($request) {
            $query->where('id', '=', $request->id)->where('job', '=', 0);
        })->count();

        $holidayCount = Attendance::where(function($query) use ($request) {
            $now = Carbon::now();
            $query->where('status', 2)->whereRaw('extract(month from attend_date) = ?', [$now->addMonth($request->month)->month]);
        })->whereHas('users', function($query) use ($request) {
            $query->where('id', '=', $request->id)->where('job', '=', 0);
        })->count();

        $absentCount = Attendance::where(function($query) use ($request) {
            $now = Carbon::now();
            $query->where('status', 3)->whereRaw('extract(month from attend_date) = ?', [$now->addMonth($request->month)->month]);
        })->whereHas('users', function($query) use ($request) {
            $query->where('id', '=', $request->id)->where('job', '=', 0);
        })->count();

        $lateCount = Attendance::where(function($query) use ($request) {
            $now = Carbon::now();
            $query->where('status', 4)->whereRaw('extract(month from attend_date) = ?', [$now->addMonth($request->month)->month]);
        })->whereHas('users', function($query) use ($request) {
            $query->where('id', '=', $request->id)->where('job', '=', 0);
        })->count();

        $allowances = Attendance::where(function($query) use ($request) {
            $now = Carbon::now();
            $query->whereRaw('extract(month from attend_date) = ?', [$now->addMonth($request->month)->month]);
        })->whereHas('users', function($query) use ($request) {
            $query->where('id', '=', $request->id)->where('job', '=', 0);
        })->sum(DB::raw('additional + bonus + incentive + reward + allowance'));

        $deductions = Attendance::where(function($query) use ($request) {
            $now = Carbon::now();
            $query->whereRaw('extract(month from attend_date) = ?', [$now->addMonth($request->month)->month]);
        })->whereHas('users', function($query) use ($request) {
            $query->where('id', '=', $request->id)->where('job', '=', 0);
        })->sum(DB::raw('discount + penalty + loan'));

        $addSalary = AddSalary::where('user_id', $request->id)->first();
        $makePayments = MakePayment::where('user_id', $request->id)->get();

        return [
            'user' => $user,
            'attendCount' => $attendCount,
            'holidayCount' => $holidayCount,
            'absentCount' => $absentCount,
            'lateCount' => $lateCount,
            'addSalary' => $addSalary,
            'date' => $date,
            'allowances' => $allowances,
            'deductions' => $deductions,
            'makePayments' => $makePayments,
        ];
    }

    public function salaryEmp(Request $request) {

        $attend = Attendance::find($request->id);

        return [
            'attend' => $attend
        ];
    }
}
