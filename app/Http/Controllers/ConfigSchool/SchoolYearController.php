<?php

namespace App\Http\Controllers\ConfigSchool;

use App\Http\Controllers\Controller;
use TCG\Voyager\Facades\Voyager;
use App\Configs\SchoolYear;
use App\Configs\Semster;
use Illuminate\Http\Request;

class SchoolYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $browes = Voyager::canOrFail('browse_year_configs');
        return view('vendor.voyager.configs.yearConfigs');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->year) {
            foreach ($request->year as $key => $item) {
                if(isset($item['id'])) {
                    SchoolYear::where('id', $item['id'])->delete();
                }
                SchoolYear::create([
                    'name'   => $item['name'],
                ]);
            }
            return response('Item\'s has been Add', 200);
        }

        if($request->semster) {
            foreach ($request->semster as $key => $item) {
                if(isset($item['id'])) {
                    Semster::where('id', $item['id'])->delete();
                }
                Semster::create([
                    'name'   => $item['name'],
                    'school_year_id' => $item['school_year_id'],
                ]);
            }
            return response('Item\'s has been Add', 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SchoolYear  $schoolYear
     * @return \Illuminate\Http\Response
     */
    public function show(SchoolYear $schoolYear)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SchoolYear  $schoolYear
     * @return \Illuminate\Http\Response
     */
    public function edit(SchoolYear $schoolYear)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SchoolYear  $schoolYear
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SchoolYear $schoolYear)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SchoolYear  $schoolYear
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchoolYear $schoolYear, $id)
    {
        SchoolYear::where('id', $id)->delete();

        return response('Item has beend deleted.', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SchoolYear  $schoolYear
     * @return \Illuminate\Http\Response
     */
    public function destroySemster($id)
    {
        Semster::where('id', $id)->delete();

        return response('Item has beend deleted.', 200);
    }

    public function getYearConfig()
    {
        $yearConfig = SchoolYear::with('semster')->get();
        $semster = Semster::with('schoolYear')->get();

        return [
            'yearConfig' => $yearConfig,
            'semster' => $semster,
        ];
    }
}
