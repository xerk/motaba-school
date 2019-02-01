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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SecretNumber  $secretNumber
     * @return \Illuminate\Http\Response
     */
    public function show(SecretNumber $secretNumber)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SecretNumber  $secretNumber
     * @return \Illuminate\Http\Response
     */
    public function edit(SecretNumber $secretNumber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SecretNumber  $secretNumber
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SecretNumber $secretNumber)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SecretNumber  $secretNumber
     * @return \Illuminate\Http\Response
     */
    public function destroy(SecretNumber $secretNumber)
    {
        //
    }
}
