<?php

namespace App\Http\Controllers;

use App\Result;
use Illuminate\Http\Request;
use App\Exports\ResultExport;
use App\Imports\ResultImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Configs\ClassRoom;
use App\Configs\ClassEdu;

class ExcelController extends Controller
{
    /**
     * Export excel from database.
     *
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        if ($request->classroom_id != '') {
            $classEdu = ClassRoom::with(['classEdu' => function($query) use($request) {
                $query->where('id', $request->class_id);
            }])->where('id', $request->classroom_id)->first();
        } else {
            $classEdu = ClassEdu::where('id', $request->class_id)->first();
        }
        // dd($classEdu);
        return Excel::download(new ResultExport($request->class_id, $request->classroom_id, $request->subject_id, $request->exam_id), $classEdu->name . ($classEdu->classEdu != null ? ' '. $classEdu->classEdu->name.'.xlsx' : '.xlsx'));
    }

    /**
     * Import excel to database.
     *
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        Excel::import(new ResultImport, $request->file('file')->store('upload'));

        return back()->with('success', 'All good!');
    }
}
