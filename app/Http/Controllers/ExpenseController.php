<?php

namespace App\Http\Controllers;

use TCG\Voyager\Facades\Voyager;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Expense;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $browes = Voyager::canOrFail('browse_expenses');
        return view('vendor.voyager.expenses.expenses');
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
            Expense::create([
                'user_id' => $request->user_id,
                'pay' => $request->model['paymentAmount'],
                'cost' => $request->model['cost'],
                'discount' => $request->model['discount'],
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
        // dd($request->all());

        if($request->model) {
            $expense = Expense::find($request->model['id']);
            $expense->pay     = $request->model['pay'];
            $expense->cost     = $request->model['cost'];
            $expense->discount     = $request->model['discount'];
            $expense->save();

            return response('Expense has been Updated !', 200);
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
        Expense::where('id', $id)->delete();

        return response('Expense has beend deleted.', 200);
    }

    public function getExpenses()
    {
        $users = User::withCount(['expenses AS paySum' => function ($query) {
                        $query->select(DB::raw("SUM(pay) as paySum"));
                    }])
                    ->with('classEdu')
                    ->withCount(['expenses AS costSum' => function ($query) {
                        $query->select(DB::raw("SUM(cost) as costSum"));
                    }])
                    ->get();

        return [
            'users' => $users,
        ];
    }

    public function studentExpenses(Request $request)
    {
        $user = User::where('id', $request->id)->with('expenses', 'classEdu')
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
            'user' => $user
        ];
    }
}
