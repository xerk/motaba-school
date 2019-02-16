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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SettingNumberDataTablesEditor $editor)
    {
        return $editor->process(request());
    }
}
