<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $page = Page::findBySlug($slug);
        return view('vendor.frontend.page', ['page' => $page]);
    }
}
