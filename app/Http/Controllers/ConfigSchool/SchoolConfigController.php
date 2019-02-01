<?php

namespace App\Http\Controllers\ConfigSchool;

use App\Http\Controllers\Controller;
use TCG\Voyager\Facades\Voyager;
use App\Configs\SchoolConfig;
use App\Configs\EduSystem;
use App\Configs\Government;
use App\Configs\EduManag;
use App\Configs\SocialMedia;
use App\Configs\Telephone;
use App\Configs\Mobile;
use App\Configs\Fax;
use App\Configs\Email;
use App\Configs\SocialMediaSchool;
use Illuminate\Http\Request;

class SchoolConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $browes = Voyager::canOrFail('browse_school_configs');
        return view('vendor.voyager.configs.schoolConfigs');
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
        if (SchoolConfig::count() > 0) {
            if($request->model) {
                $schoolConfig = SchoolConfig::find($request->model['id']);
                $schoolConfig->school_name        = $request->model['school_name'];
                $schoolConfig->edu_system_id      = $request->model['edu_system_id'];
                $schoolConfig->government_id      = $request->model['government_id'];
                $schoolConfig->edu_manag_id       = $request->model['edu_manag_id'];
                $schoolConfig->address            = $request->model['address'];
                $schoolConfig->school_manager     = $request->model['school_manager'];
                $schoolConfig->follow_manager     = $request->model['follow_manager'];
                $schoolConfig->website            = $request->model['website'];
                $schoolConfig->license_number     = $request->model['license_number'];
                $schoolConfig->school_logo        = $request->model['school_logo'];
                $schoolConfig->school_cover       = $request->model['school_cover'];
                $schoolConfig->footer             = $request->model['footer'];
                $schoolConfig->save();

                Telephone::where('school_config_id', $request->model['id'])->delete();
                Mobile::where('school_config_id', $request->model['id'])->delete();
                Fax::where('school_config_id', $request->model['id'])->delete();
                Email::where('school_config_id', $request->model['id'])->delete();
                SocialMediaSchool::where('school_config_id', $request->model['id'])->delete();

                if ($request->telephones) {
                    foreach ($request->telephones as $key => $telephone) {
                        Telephone::create([
                            'tel'   => $telephone['tel'],
                            'school_config_id'   => $request->model['id'],
                        ]);
                    }
                }

                if ($request->mobiles) {
                    foreach ($request->mobiles as $key => $mobile) {
                        Mobile::create([
                            'mobile'   => $mobile['mobile'],
                            'school_config_id'   => $request->model['id'],
                        ]);
                    }
                }

                if ($request->faxes) {
                    foreach ($request->faxes as $key => $fax) {
                        Fax::create([
                            'fax'   => $fax['fax'],
                            'school_config_id'   => $request->model['id'],
                        ]);
                    }
                }

                if ($request->emails) {
                    foreach ($request->emails as $key => $email) {
                        Email::create([
                            'email'   => $email['email'],
                            'school_config_id'   => $request->model['id'],
                        ]);
                    }
                }

                if ($request->socialMedia) {
                    foreach ($request->socialMedia as $key => $social) {
                        SocialMediaSchool::create([
                            'link'   => $social['link'],
                            'social_id' => $social['social_id'],
                            'school_config_id'   => $request->model['id'],
                        ]);
                    }
                } 
                
                return response('Successfully Updated School Configs', 200);
            }

        } else {
            if ($request->model) {
                $data = SchoolConfig::create([
                    'school_name' => $request->model['schoolName'],
                    'edu_system_id' => $request->model['eduSystem'],
                    'government_id' => $request->model['government'],
                    'edu_manag_id' => $request->model['eduManag'],
                    'address' => $request->model['address'],
                    'school_manager' => $request->model['schoolManger'],
                    'follow_manager' => $request->model['followManager'],
                    'website' => $request->model['website'],
                    'license_number' => $request->model['licenseNumber'],
                    'footer' => $request->model['footer'],
                ]);
            }
    
            if ($request->telephones) {
                foreach ($request->telephones as $key => $telephone) {
                    Telephone::create([
                        'tel'   => $telephone['option'],
                        'school_config_id'   => $data->id,
                    ]);
                }
            }

            if ($request->mobiles) {
                foreach ($request->mobiles as $key => $mobile) {
                    Mobile::create([
                        'mobile'   => $mobile['option'],
                        'school_config_id'   => $data->id,
                    ]);
                }
            }

            if ($request->faxes) {
                foreach ($request->faxes as $key => $fax) {
                    Fax::create([
                        'fax'   => $fax['option'],
                        'school_config_id'   => $data->id,
                    ]);
                }
            }

            if ($request->emails) {
                foreach ($request->emails as $key => $email) {
                    Email::create([
                        'email'   => $email['option'],
                        'school_config_id'   => $data->id,
                    ]);
                }
            }

            if ($request->socialMedia) {
                foreach ($request->socialMedia as $key => $social) {
                    SocialMediaSchool::create([
                        'link'   => $social['link'],
                        'social_id' => $social['name'],
                        'school_config_id'   => $data->id,
                    ]);
                }
            }           
            return response('Successfully Added School Configs', 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SchoolConfig  $schoolConfig
     * @return \Illuminate\Http\Response
     */
    public function show(SchoolConfig $schoolConfig)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SchoolConfig  $schoolConfig
     * @return \Illuminate\Http\Response
     */
    public function edit(SchoolConfig $schoolConfig)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SchoolConfig  $schoolConfig
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SchoolConfig $schoolConfig)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SchoolConfig  $schoolConfig
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchoolConfig $schoolConfig)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDataConfig()
    {
        $eduSystems = EduSystem::all();
        $governments = Government::all();
        $eduManags = EduManag::all();
        $socialMedia = SocialMedia::all();
        $data = SchoolConfig::first();
        $telephones = Telephone::all();
        $mobiles = Mobile::all();
        $faxes = Fax::all();
        $emails = Email::all();
        $socialSchool = SocialMediaSchool::all();

        return [
            'data' => $data,
            'eduSystems' => $eduSystems,
            'governments' => $governments,
            'eduManags' => $eduManags,
            'socialMedia' => $socialMedia,
            'telephones' => $telephones,
            'mobiles' => $mobiles,
            'faxes' => $faxes,
            'emails' => $emails,
            'socialSchool' => $socialSchool,
        ];
    }

    public function eduManag(Request $request)
    {
        return EduManag::where('government_id', $request->id)->get();
    }
}
