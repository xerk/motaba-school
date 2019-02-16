<?php

namespace App\Http\Controllers;

use App\Committee;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;

class CommitteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $browes = Voyager::canOrFail('browse_committees');
        return view('vendor.voyager.committee.committee');
    }

}
