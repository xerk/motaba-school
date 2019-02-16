<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SchoolDefinition;
use App\Testimonial;

class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schoolDefi = SchoolDefinition::all();
        $testimonials = Testimonial::all();
        return view('vendor.frontend.landing-page', [
            'schoolDefi' => $schoolDefi,
            'testimonials' => $testimonials
        ]);
    }
}
