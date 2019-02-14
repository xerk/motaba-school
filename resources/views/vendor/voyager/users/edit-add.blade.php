@extends('voyager::master')

@section('page_title', __('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular)

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.'.(isset($dataTypeContent->id) ? 'edit' : 'add')).' '.$dataType->display_name_singular }}
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        <form class="form-edit-add" role="form"
              action="{{ (isset($dataTypeContent->id)) ? route('voyager.'.$dataType->slug.'.update', $dataTypeContent->id) : route('voyager.'.$dataType->slug.'.store') }}"
              method="POST" enctype="multipart/form-data" autocomplete="off">
            <!-- PUT Method if we are editing -->
            @if(isset($dataTypeContent->id))
                {{ method_field("PUT") }}
            @endif
            {{ csrf_field() }}

            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-bordered">
                    {{-- <div class="panel"> --}}
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __('First Name')}}</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="{{ __('First Name')}}"
                                               value="@if(isset($dataTypeContent->name)){{ $dataTypeContent->name }}@endif">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">{{__('Last Name')}}</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" placeholder="{{__('Last Name')}}"
                                               value="@if(isset($dataTypeContent->last_name)){{ $dataTypeContent->last_name }}@endif">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email">{{ __('voyager::generic.email') }}</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="{{ __('voyager::generic.email') }}"
                                       value="@if(isset($dataTypeContent->email)){{ $dataTypeContent->email }}@endif">
                            </div>

                            <div class="form-group">
                                <label for="username">{{ __('Username') }}</label>
                                <input type="username" class="form-control" id="username" name="username" placeholder="{{ __('Username') }}"
                                        value="@if(isset($dataTypeContent->username)){{ $dataTypeContent->username }}@endif">
                            </div>

                            <div class="form-group">
                                <label for="password">{{ __('voyager::generic.password') }}</label>
                                @if(isset($dataTypeContent->password))
                                    <br>
                                    <small>{{ __('voyager::profile.password_hint') }}</small>
                                @endif
                                <input type="password" class="form-control" id="password" name="password" value="" autocomplete="new-password">
                            </div>

                            @can('editRoles', $dataTypeContent)
                                <div class="form-group">
                                    <label for="default_role">{{ __('voyager::profile.role_default') }}</label>
                                    @php
                                        $dataTypeRows = $dataType->{(isset($dataTypeContent->id) ? 'editRows' : 'addRows' )};
                                        $row     = $dataTypeRows->where('field', 'user_belongsto_role_relationship')->first();
                                        $options = json_decode($row->details);
                                    @endphp
                                    @include('voyager::formfields.relationship')
                                </div>
                                <div class="form-group">
                                    <label for="additional_roles">{{ __('voyager::profile.roles_additional') }}</label>
                                    @php
                                        $row     = $dataTypeRows->where('field', 'user_belongstomany_role_relationship')->first();
                                        $options = json_decode($row->details);
                                    @endphp
                                    @include('voyager::formfields.relationship')
                                </div>
                            @endcan
                            @php
                            if (isset($dataTypeContent->locale)) {
                                $selected_locale = $dataTypeContent->locale;
                            } else {
                                $selected_locale = config('app.locale', 'en');
                            }
                            @endphp
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="birth_date">{{__('Birth Date')}}</label>
                                        <input type="date" class="form-control" id="birth_date" name="birth_date" placeholder="{{__('Birth Date')}}"
                                                value="@if(isset($dataTypeContent->birth_date)){{ $dataTypeContent->birth_date }}@endif">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address">{{__('Address')}}</label>
                                        <input type="text" class="form-control" id="address" name="address" placeholder="{{__('Address')}}"
                                                value="@if(isset($dataTypeContent->address)){{ $dataTypeContent->address }}@endif">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nationality">{{__('Nationality')}}</label>
                                        <input type="text" class="form-control" id="nationality" name="nationality" placeholder="{{__('Nationality')}}"
                                                value="@if(isset($dataTypeContent->nationality)){{ $dataTypeContent->nationality }}@endif">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="national_id">{{__('National ID')}}</label>
                                        <input type="number" class="form-control" id="national_id" name="national_id" placeholder="{{__('National ID')}}"
                                                value="@if(isset($dataTypeContent->national_id)){{ $dataTypeContent->national_id }}@endif">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mobile">{{__('Mobile')}}</label>
                                        <input type="number" class="form-control" id="mobile" name="mobile" placeholder="{{__('Mobile')}}"
                                                value="@if(isset($dataTypeContent->mobile)){{ $dataTypeContent->mobile }}@endif">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tel">{{__('Telephone')}}</label>
                                        <input type="number" class="form-control" id="tel" name="tel" placeholder="{{__('Telephone')}}"
                                                value="@if(isset($dataTypeContent->tel)){{ $dataTypeContent->tel }}@endif">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel panel panel-bordered panel-warning">
                        <div class="panel-body">
                            <div class="form-group">
                                @if(isset($dataTypeContent->avatar))
                                    <img src="{{ filter_var($dataTypeContent->avatar, FILTER_VALIDATE_URL) ? $dataTypeContent->avatar : Voyager::image( $dataTypeContent->avatar ) }}" style="width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;" />
                                @endif
                                <input type="file" data-name="avatar" name="avatar">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel panel-bordered panel-warning">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gender">{{__('Religion')}}</label>
                                        <br>
                                        <?php $checked = true ?>
                                        <input type="checkbox" name="religion" class="toggleswitch"
                                            data-on="{{__('Muslim')}}" @if(isset($dataTypeContent->religion) && $dataTypeContent->religion == true) checked="checked" @endif @if(!isset($dataTypeContent->religion)) {!! $checked ? 'checked="checked"' : '' !!} @endif
                                            data-off="{{__('Christian')}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gender">{{__('Gender')}}</label>
                                        <br>
                                        <?php $checked = true ?>
                                        <input type="checkbox" name="gender" class="toggleswitch"
                                            data-on="{{__('Male')}}" @if(isset($dataTypeContent->gender) && $dataTypeContent->gender == true) checked="checked" @endif @if(!isset($dataTypeContent->gender)) {!! $checked ? 'checked="checked"' : '' !!} @endif
                                            data-off="{{__('Female')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="locale">{{ __('voyager::generic.locale') }}</label>
                                <select class="form-control select2" id="locale" name="locale">
                                    @foreach (Voyager::getLocales() as $locale)
                                    <option value="{{ $locale }}"
                                    {{ ($locale == $selected_locale ? 'selected' : '') }}>{{ $locale == 'ar' ? __('Arabic') : ($locale == 'en' ? __('English') : $locale) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @php
                            if (isset($dataTypeContent->job)) {
                                $selected_job = $dataTypeContent->job;
                            } else {
                                $selected_job = '';
                            }
                            @endphp
                            <div class="form-group">
                                <label for="job">{{__('Job')}}</label>
                                <select class="form-control select2" id="job" name="job">
                                    <option {{ ($selected_job == null ? 'selected' : '') }} value="">{{ __('voyager::generic.none')}}</option>
                                    <option {{ ($selected_job == 1 ? 'selected' : '') }} value="1">{{__('Student')}}</option>
                                    <option {{ ($selected_job == 0 ? 'selected' : '') }} value="0">{{__('Employee')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" id="student" style="{{ $selected_job == 1 ? "" : "display:none"}}">
                    <div class="panel panel panel-bordered panel-warning">
                        <div class="panel-body">
                            @php
                                if (isset($dataTypeContent->status)) {
                                    $selected_status = $dataTypeContent->status;
                                } else {
                                    $selected_status = '';
                                }
                            @endphp
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="area_code">{{__('Area Code')}}</label>
                                        <input type="text" class="form-control" id="area_code" name="area_code" placeholder="{{__('Area Code')}}"
                                                value="@if(isset($dataTypeContent->area_code)){{ $dataTypeContent->area_code }}@endif">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status">{{__('Status')}}</label>
                                        <select class="form-control select2" id="status" name="status">
                                            <option {{ ($selected_status == null ? 'selected' : '') }} value="">{{ __('voyager::generic.none')}}</option>
                                            <option {{ ($selected_status == 1 ? 'selected' : '') }} value="1">{{__('New')}}</option>
                                            <option {{ ($selected_status == 2 ? 'selected' : '') }} value="2">{{__('Transported')}}</option>
                                            <option {{ ($selected_status == 3 ? 'selected' : '') }} value="3">{{__('Newcomer')}}</option>
                                            <option {{ ($selected_status == 3 ? 'selected' : '') }} value="4">{{__('Transfer')}}</option>
                                            <option {{ ($selected_status == 3 ? 'selected' : '') }} value="5">{{__('Failure')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="joining_date">{{__('Joining Date')}}</label>
                                        <input type="date" class="form-control" id="joining_date" name="joining_date" placeholder="{{__('Joining Date')}}"
                                                value="@if(isset($dataTypeContent->joining_date)){{ $dataTypeContent->joining_date }}@endif">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="enrollment_no">{{__('Enrollment number')}}</label>
                                        <input type="number" class="form-control" id="enrollment_no" name="enrollment_no" placeholder="{{__('Enrollment number')}}"
                                                value="@if(isset($dataTypeContent->enrollment_no)){{ $dataTypeContent->enrollment_no }}@endif">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    @php
                                        if (isset($dataTypeContent->stage_id)) {
                                            $selected_stage = $dataTypeContent->stage_id;
                                        } else {
                                            $selected_stage = '';
                                        }
                                    @endphp
                                    <div class="form-group">
                                        <label for="stage_id">{{__('Stage Education')}}</label>
                                        <select class="form-control select2" id="stage_id" name="stage_id">
                                            <option value="">{{ __('voyager::generic.none')}}</option>
                                            @foreach (App\Configs\StageEdu::all() as $stage)
                                                <option value="{{ $stage->id }}"
                                                {{ ($stage->id == $selected_stage ? 'selected' : '') }}>{{ $stage->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    @php
                                        if (isset($dataTypeContent->class_id)) {
                                            $selected_class = $dataTypeContent->class_id;
                                        } else {
                                            $selected_class = '';
                                        }
                                    @endphp
                                    <div class="form-group">
                                        <label for="class_id">{{__('Class Education')}}</label>
                                        <select class="form-control select2" id="class_id" name="class_id">
                                            <option value="">{{ __('voyager::generic.none')}}</option>
                                            @foreach (App\Configs\ClassEdu::with('stageEdu')->get() as $class)
                                                <option value="{{ $class->id }}"{{ ($class->id == $selected_class ? 'selected' : '') }}> {{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    @php
                                        if (isset($dataTypeContent->classroom_id)) {
                                            $selected_classRoom = $dataTypeContent->classroom_id;
                                        } else {
                                            $selected_classRoom = '';
                                        }
                                    @endphp
                                    <div class="form-group">
                                        <label for="classroom_id">{{__('Class Room')}}</label>
                                        <select class="form-control select2" id="classroom_id" name="classroom_id">
                                            <option value="">{{ __('voyager::generic.none')}}</option>
                                            @foreach (App\Configs\ClassRoom::with('classEdu')->get() as $classRoom)
                                                <option value="{{ $classRoom->id }}"
                                                {{ ($classRoom->id == $selected_classRoom ? 'selected' : '') }}>{{ $classRoom->name }} - {{ $classRoom->classEdu->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    @php
                                    if (isset($dataTypeContent->sight)) {
                                        $selected_sight = $dataTypeContent->sight;
                                    } else {
                                        $selected_sight = '';
                                    }
                                    @endphp
                                    <div class="form-group">
                                        <label for="sight">{{__('Sight')}}</label>
                                        <select class="form-control select2" id="sight" name="sight">
                                            <option {{ ($selected_sight == null ? 'selected' : '') }} value="">{{ __('voyager::generic.none')}}</option>
                                            <option {{ ($selected_sight == 1 ? 'selected' : '') }} value="1">{{__('Visualized')}}</option>
                                            <option {{ ($selected_sight == 0 ? 'selected' : '') }} value="0">{{__('Blind')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    @php
                                    if (isset($dataTypeContent->student_status)) {
                                        $selected_student_status = $dataTypeContent->student_status;
                                    } else {
                                        $selected_student_status = '';
                                    }
                                    @endphp
                                    <div class="form-group">
                                        <label for="student_status">{{__('Student Status')}}</label>
                                        <select class="form-control select2" id="student_status" name="student_status">
                                            <option {{ ($selected_student_status == null ? 'selected' : '') }} value="">{{ __('voyager::generic.none')}}</option>
                                            <option {{ ($selected_student_status == 0 ? 'selected' : '') }} value="0">{{__('Normal')}}</option>
                                            <option {{ ($selected_student_status == 1 ? 'selected' : '') }} value="1">{{__('Listener')}}</option>
                                            <option {{ ($selected_student_status == 2 ? 'selected' : '') }} value="2">{{__('Orphan')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    @php
                                    if (isset($dataTypeContent->doctrine)) {
                                        $selected_doctrine = $dataTypeContent->doctrine;
                                    } else {
                                        $selected_doctrine = '';
                                    }
                                    @endphp
                                    <div class="form-group">
                                        <label for="doctrine">{{__('Doctrine')}}</label>
                                        <select class="form-control select2" id="doctrine" name="doctrine">
                                            <option {{ ($selected_doctrine == null ? 'selected' : '') }} value="">{{ __('voyager::generic.none')}}</option>
                                            <option {{ ($selected_doctrine == 1 ? 'selected' : '') }} value="1">{{__('Shafei')}}</option>
                                            <option {{ ($selected_doctrine == 2 ? 'selected' : '') }} value="2">{{__('Hanafi')}}</option>
                                            <option {{ ($selected_doctrine == 3 ? 'selected' : '') }} value="3">{{__('Al Malki')}}</option>
                                            <option {{ ($selected_doctrine == 4 ? 'selected' : '') }} value="4">{{__('Hambali')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="father_job">{{__('Father Job')}}</label>
                                        <input type="text" class="form-control" id="father_job" name="father_job" placeholder="{{__('Father Job')}}"
                                                value="@if(isset($dataTypeContent->father_job)){{ $dataTypeContent->father_job }}@endif">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="father_qualified">{{__('Father Qualified')}}</label>
                                        <input type="text" class="form-control" id="father_qualified" name="father_qualified" placeholder="{{__('Father Qualified')}}"
                                                value="@if(isset($dataTypeContent->father_qualified)){{ $dataTypeContent->father_qualified }}@endif">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="father_mobile">{{__('Father Mobile')}}</label>
                                        <input type="text" class="form-control" id="father_mobile" name="father_mobile" placeholder="{{__('Father Mobile')}}"
                                                value="@if(isset($dataTypeContent->father_mobile)){{ $dataTypeContent->father_mobile }}@endif">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="father_tel">{{__('Father Telephone')}}</label>
                                        <input type="text" class="form-control" id="father_tel" name="father_tel" placeholder="{{__('Father Telephone')}}"
                                                value="@if(isset($dataTypeContent->father_tel)){{ $dataTypeContent->father_tel }}@endif">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mother_name">{{__('Mother Name')}}</label>
                                        <input type="text" class="form-control" id="mother_name" name="mother_name" placeholder="{{__('Mother Name')}}"
                                                value="@if(isset($dataTypeContent->mother_name)){{ $dataTypeContent->mother_name }}@endif">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mother_job">{{__('Mother Job')}}</label>
                                        <input type="text" class="form-control" id="mother_job" name="mother_job" placeholder="{{__('Mother Job')}}"
                                                value="@if(isset($dataTypeContent->mother_job)){{ $dataTypeContent->mother_job }}@endif">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mother_qualified">{{__('Mother Qualified')}}</label>
                                        <input type="text" class="form-control" id="mother_qualified" name="mother_qualified" placeholder="{{__('Mother Qualified')}}"
                                                value="@if(isset($dataTypeContent->mother_qualified)){{ $dataTypeContent->mother_qualified }}@endif">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mother_mobile">{{__('Mother Mobile')}}</label>
                                        <input type="text" class="form-control" id="mother_mobile" name="mother_mobile" placeholder="{{__('Mother Mobile')}}"
                                                value="@if(isset($dataTypeContent->mother_mobile)){{ $dataTypeContent->mother_mobile }}@endif">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mother_tel">{{__('Mother Telephone')}}</label>
                                        <input type="text" class="form-control" id="mother_tel" name="mother_tel" placeholder="{{__('Mother Telephone')}}"
                                                value="@if(isset($dataTypeContent->mother_tel)){{ $dataTypeContent->mother_tel }}@endif">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" id="employee" style="{{ $selected_job == 0 ? "" : "display:none"}}">
                    <div class="panel panel panel-bordered panel-warning">
                        <div class="panel-body">
                            <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="qualification">{{__('Qualification')}}</label>
                                        <input type="text" class="form-control" id="qualification" name="qualification" placeholder="{{__('Qualification')}}"
                                                value="@if(isset($dataTypeContent->qualification)){{ $dataTypeContent->qualification }}@endif">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="specialty">{{__('Specialty')}}</label>
                                        <input type="text" class="form-control" id="specialty" name="specialty" placeholder="{{__('Specialty')}}"
                                                value="@if(isset($dataTypeContent->specialty)){{ $dataTypeContent->specialty }}@endif">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="date_receipt">{{__('Date Receipt')}}</label>
                                        <input type="date" class="form-control" id="date_receipt" name="date_receipt" placeholder="{{__('Date Receipt')}}"
                                                value="@if(isset($dataTypeContent->date_receipt)){{ $dataTypeContent->date_receipt }}@endif">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Insurance_date">{{__('Insurance Date')}}</label>
                                        <input type="date" class="form-control" id="Insurance_date" name="Insurance_date" placeholder="{{__('Insurance Date')}}"
                                                value="@if(isset($dataTypeContent->Insurance_date)){{ $dataTypeContent->Insurance_date }}@endif">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Insurance_no">{{__('Insurance Number')}}</label>
                                        <input type="text" class="form-control" id="Insurance_no" name="Insurance_no" placeholder="{{__('Insurance Number')}}"
                                                value="@if(isset($dataTypeContent->Insurance_no)){{ $dataTypeContent->Insurance_no }}@endif">
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary pull-right save">
                {{ __('voyager::generic.save') }}
            </button>
        </form>

        <iframe id="form_target" name="form_target" style="display:none"></iframe>
        <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post" enctype="multipart/form-data" style="width:0px;height:0;overflow:hidden">
            {{ csrf_field() }}
            <input name="image" id="upload_file" type="file" onchange="$('#my_form').submit();this.value='';">
            <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
        </form>
    </div>
@stop

@section('javascript')
    <script>
        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();
            $('#job').change(function(){
                if($('#job').val() == '1') {
                    $('#student').show(); 
                    $('#employee').hide();
                } else if ($('#job').val() == '0') {
                    $('#employee').show();
                    $('#student').hide();
                } else {
                    $('#employee').hide();
                    $('#student').hide();
                } 
            });
        });
    </script>
@stop