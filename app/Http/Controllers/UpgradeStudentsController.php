<?php

namespace App\Http\Controllers;

use App\User;
use App\Configs\ClassEdu;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;
use App\Http\Controllers\Controller;

class UpgradeStudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $browes = Voyager::canOrFail('browse_upgrade_students');
        return view('vendor.voyager.upgrade-students.upgrade');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upgradeData(Request $request)
    {
        $classEdus = ClassEdu::with(['users' => function ($q) {
            $q->whereNull('classroom_id')->where('job', 1);
        }, 'classRoom' => function ($q) {
            $q->with('users');
        }])->where('id', $request->id)->first() ;

        return response()->json([
            'classEdus' => $classEdus
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateEmptyClass(Request $request)
    {   
        // $result = '';
        foreach ($request->users as $user) {
            User::where('id', $user['id'])->update(['classroom_id' => null]);
        }
        return response()->json('نجحة العملية');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateAddToRoom(Request $request)
    {   
        // $result = '';
        foreach ($request->users as $user) {
            User::where('id', $user['id'])->update(['classroom_id' => $request->id]);
        }
        return response()->json('نجحة العملية');
    }

}
