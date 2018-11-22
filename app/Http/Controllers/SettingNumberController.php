<?php

namespace App\Http\Controllers;

use App\User;
use App\SettingNumber;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;
use App\DataTables\SettingNumberDataTable;
use App\DataTables\SettingNumberDataTablesEditor;


class SettingNumberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SettingNumberDataTable $dataTable)
    {
        $browes = Voyager::canOrFail('browse_setting_numbers');
        return view('vendor.voyager.setting-number.setting-number');
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
    public function store(SettingNumberDataTablesEditor $editor)
    {
        return $editor->process(request());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SettingNumber  $settingNumber
     * @return \Illuminate\Http\Response
     */
    public function show(SettingNumber $settingNumber)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SettingNumber  $settingNumber
     * @return \Illuminate\Http\Response
     */
    public function edit(SettingNumber $settingNumber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SettingNumber  $settingNumber
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SettingNumber $settingNumber)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SettingNumber  $settingNumber
     * @return \Illuminate\Http\Response
     */
    public function destroy(SettingNumber $settingNumber)
    {
        //
    }
}
