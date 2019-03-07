<?php

namespace App\Http\Controllers;

use App\Result;
use Illuminate\Http\Request;
use App\Exports\ResultExport;
use App\Imports\ResultImport;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    /**
     * Export excel from database.
     *
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        return Excel::download(new ResultExport($request->class_id, $request->classroom_id, $request->subject_id, $request->exam_id), 'results.xlsx');
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
