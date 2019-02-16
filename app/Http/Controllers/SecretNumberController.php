<?php

namespace App\Http\Controllers;

use App\SecretNumber;
use Illuminate\Http\Request;
use TCG\Voyager\Facades\Voyager;

class SecretNumberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $browes = Voyager::canOrFail('browse_secret_numbers');
        return view('vendor.voyager.secret-number.secret-number');
    }

}
