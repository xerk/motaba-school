@extends('vendor.frontend.layout.layout')
@section('title', __('Profile'))
@section('body-class', 'at-'.Auth::user()->username)
@section('extra-css')
    <style>
        .uk-subnav>*>:first-child {
            text-transform: none;
        }
        .uk-subnav {
            justify-content: left;
            border-bottom: 1px solid #f1f1f5;
        }
        .uk-subnav-pill>.uk-active>a {
            background-color: #fff;
            color: #000;
            border-bottom: 2px solid #1e87f0;
        }
        .show-result {
            font-weight: 600;
        }
    </style>
@endsection
@section('content')
<div class="uk-container uk-margin-top profile" id="profile">
    <div class="uk-text-left" uk-grid>
        <div class="uk-width-1-2@s uk-width-1-3@m">
            <div class="uk-card uk-card-default uk-card-nav">
                <div class="uk-card-body">
                    <div class="user_image">
                        <img class="uk-border-circle" src="{{ Voyager::image(Auth::user()->avatar) }}">
                    </div>
                    <h3 class="uk-card-title">{{ Auth::user()->name }} {{ Auth::user()->last_name }}</h3>
                    <p class="username">{{ '@'.Auth::user()->username }}</p>
                    <hr>
                    <div v-if="showContent == true">
                        <div class="uk-text-left uk-grid-small uk-child-width-expand@s" uk-grid>
                            <span class="uk-text-muted">{{ __('Email')}}:</span>
                            <span class="uk-text-bold uk-text-primary">{{ Auth::user()->email }}</span>
                        </div>
                        <div class="uk-grid-small uk-text-left uk-child-width-expand@s" uk-grid>
                            <span class="uk-text-muted">{{__('Birth Date')}}:</span>
                            <span class="uk-text-bold uk-text-primary">{{ \Carbon\Carbon::parse(Auth::user()->birth_date)->toFormattedDateString() }}</span>
                        </div>
                        <div class="uk-text-left uk-grid-small uk-child-width-expand@s" uk-grid>
                                <span class="uk-text-muted">{{__('Mobile')}}:</span>
                                <span class="uk-text-bold uk-text-primary">{{ Auth::user()->mobile }}</span>
                        </div>
                        <div class="uk-text-left uk-grid-small uk-child-width-expand@s" uk-grid>
                                <span class="uk-text-muted">{{__('Telephone')}}:</span>
                                <span class="uk-text-bold uk-text-primary">{{ Auth::user()->tel }}</span>
                        </div>
                        <div class="uk-text-left uk-grid-small uk-child-width-expand@s" uk-grid>
                                <span class="uk-text-muted">{{__('Address')}}:</span>
                                <span class="uk-text-bold uk-text-primary">{{ Auth::user()->address }}</span>
                        </div>
                        <div class="uk-text-left uk-grid-small uk-child-width-expand@s" uk-grid>
                                <span class="uk-text-muted">{{__('Nationality')}}:</span>
                                <span class="uk-text-bold uk-text-primary">{{ Auth::user()->nationality }}</span>
                        </div>
                        <div class="uk-text-left uk-grid-small uk-child-width-expand@s" uk-grid>
                                <span class="uk-text-muted">{{__('National ID')}}:</span>
                                <span class="uk-text-bold uk-text-primary">{{ Auth::user()->national_id }}</span>
                        </div>
                        <hr>
                    </div>
                    <span class="show-result">
                        <a v-if="showContent == false" @click.prevent="showContent = true" href="">{{__('Show Content')}}</a>
                        <a v-if="showContent == true" @click.prevent="showContent = false" href="">{{__('Hiden Content')}}</a>
                    </span>
                    {{-- <p class="about"></p> --}}
                </div>
            </div>
        </div>
        <div class="uk-width-1-2@s uk-width-2-3@m">
            <div class="uk-card uk-card-default">
                <div class="uk-card-body">
                    <ul class="uk-subnav uk-subnav-pill" uk-switcher="animation: uk-animation-slide-left-medium, uk-animation-slide-right-medium">
                        <li><a href="#">{{__('Profile Information')}}</a></li>
                        <li><a href="#">{{__('Schedule')}}</a></li>
                        <li><a href="#">{{__('Attendance')}}</a></li>
                        <li><a href="#">{{__('Expenses')}}</a></li>
                        <li><a href="#">{{__('Result')}}</a></li>
                    </ul>
                    <ul class="uk-switcher uk-margin">
                        <li>
                            <h3 class="uk-margin-small-bottom">{{ __('Personal Info')}}.</h3>
                            @if (Auth::user()->job == 1)
                            <ul class="uk-list uk-list-divider">
                                @if (Auth::user()->status != Null)
                                <li>
                                    <div class="uk-grid-small uk-text-left uk-child-width-expand@s" uk-grid>
                                        <span class="uk-text-muted">{{__('Status')}}:</span>
                                        @switch(Auth::user()->status)
                                            @case(1)
                                                <span class="uk-text-bold uk-text-success">{{__('New')}}</span>
                                                @break
                                            @case(2)
                                                <span class="uk-text-bold uk-text-primary">{{__('Transported')}}</span>
                                                @break
                                            @case(3)
                                                <span class="uk-text-bold uk-text-warning">{{__('Newcomer')}}</span>
                                                @break
                                            @default
                                                <span class="uk-text-bold uk-text-muted">{{__('Nothing')}}</span>
                                        @endswitch
                                    </div>
                                </li>
                                @endif
                                @if (Auth::user()->joining_date != Null)
                                <li>
                                    <div class="uk-grid-small uk-text-left uk-child-width-expand@s" uk-grid>
                                        <span class="uk-text-muted">{{__('Joining Date')}} :</span>
                                        <span class="uk-text-bold uk-text-primary">{{ \Carbon\Carbon::parse(Auth::user()->joining_date)->toFormattedDateString() }}</span>
                                    </div>
                                </li>
                                @endif
                                @if (Auth::user()->stage_id != Null)
                                <li>
                                    <div class="uk-grid-small uk-text-left uk-child-width-expand@s" uk-grid>
                                        <span class="uk-text-muted">{{__('Education info')}}:</span>
                                        <span class="uk-text-bold uk-text-primary">{{ Auth::user()->stageEdu->name }} - {{ Auth::user()->classEdu->name }} ({{ Auth::user()->classRoom->name }})</span>
                                    </div>
                                </li>
                                @endif
                                @if (Auth::user()->enrollment_no != Null)                                
                                <li v-if="showPrsonalInfo == true">
                                    <div class="uk-grid-small uk-text-left uk-child-width-expand@s" uk-grid>
                                        <span class="uk-text-muted">{{__('Enrollment number')}}:</span>
                                        <span class="uk-text-bold uk-text-primary">{{ Auth::user()->enrollment_no }}</span>
                                    </div>
                                </li>
                                @endif
                                @if (Auth::user()->father_mobile != Null)                                
                                <li v-if="showPrsonalInfo == true">
                                    <div class="uk-grid-small uk-text-left uk-child-width-expand@s" uk-grid>
                                        <span class="uk-text-muted">{{__('Father Mobile' )}}:</span>
                                        <span class="uk-text-bold uk-text-primary">{{ Auth::user()->father_mobile }}</span>
                                    </div>
                                </li>
                                @endif
                                @if (Auth::user()->father_tel != Null)                                
                                <li v-if="showPrsonalInfo == true">
                                    <div class="uk-grid-small uk-text-left uk-child-width-expand@s" uk-grid>
                                        <span class="uk-text-muted">{{__('Father Telephone')}}:</span>
                                        <span class="uk-text-bold uk-text-primary">{{ Auth::user()->father_tel }}</span>
                                    </div>
                                </li>
                                @endif
                            </ul>
                            @else

                            @endif
                            <hr>
                            <span class="show-result uk-text-center">
                                <a v-if="showPrsonalInfo == false" @click.prevent="showPrsonalInfo = true" href="">{{__('Show More')}}</a>
                                <a v-if="showPrsonalInfo == true" @click.prevent="showPrsonalInfo = false" href="">{{__('Hiden More')}}</a>
                            </span>
                        </li>
                        <li>
                            <h3 class="uk-margin-small-bottom">{{__('Schedule')}}.</h3>
                            {{__('Coming soon')}}...</li>
                        <li>
                            <h3 class="uk-margin-small-bottom">{{__('Attendance')}}.</h3>
                            <ul class="uk-list uk-list-divider">
                                <li>
                                    <div class="uk-grid-small uk-text-left uk-child-width-expand@s" uk-grid>
                                        <span class="uk-text-muted">{{__('Attend')}}:</span>
                                        <span class="uk-text-bold uk-text-primary">{{ Auth::user()->attendance->where('status', 1)->count() }}</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="uk-grid-small uk-text-left uk-child-width-expand@s" uk-grid>
                                        <span class="uk-text-muted">{{__('Holiday')}}:</span>
                                        <span class="uk-text-bold uk-text-success">{{ Auth::user()->attendance->where('status', 2)->count() }}</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="uk-grid-small uk-text-left uk-child-width-expand@s" uk-grid>
                                        <span class="uk-text-muted">{{__('Absent')}}:</span>
                                        <span class="uk-text-bold uk-text-danger">{{ Auth::user()->attendance->where('status', 3)->count() }}</span>
                                    </div>
                                </li>
                            </ul>
                            <table class="uk-table uk-table-striped" v-if="showAttendContent == true">
                                    <thead>
                                        <tr>
                                            <th>{{__('Status')}}</th>
                                            <th>{{__('Attend Date')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (Auth::user()->attendance as $item)
                                            <tr>
                                                @switch($item->status)
                                                    @case(1)
                                                        <td class="uk-text-primary">{{__('Attend')}}</td>
                                                        @break
                                                    @case(2)
                                                        <td class="uk-text-success">{{__('Holiday')}}</td>
                                                        @break
                                                    @case(3)
                                                        <td class="uk-text-danger">{{__('Absent')}}</td>
                                                        @break
                                                    @default
                                                        <td>{{__('Nothing')}}</td>
                                                @endswitch
                                                <td>{{ \Carbon\Carbon::parse($item->attend_date)->toFormattedDateString() }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <hr>
                                <span class="show-result uk-text-center">
                                    <a v-if="showAttendContent == false" @click.prevent="showAttendContent = true" href="">{{__('Show Table')}}</a>
                                    <a v-if="showAttendContent == true" @click.prevent="showAttendContent = false" href="">{{__('Hiden Table')}}</a>
                                </span>
                        </li>
                        <li>
                            <h3 class="uk-margin-small-bottom">{{__('Expenses')}}.</h3>
                            <ul class="uk-list uk-list-divider">
                                <li>
                                    <div class="uk-grid-small uk-text-left uk-child-width-expand@s" uk-grid>
                                        <span class="uk-text-muted">{{__('Basic Cost')}}:</span>
                                        <span class="uk-text-bold uk-text-primary">{{ Auth::user()->expenses->sum('cost') + Auth::user()->classEdu->expenses_cost }}</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="uk-grid-small uk-text-left uk-child-width-expand@s" uk-grid>
                                        <span class="uk-text-muted">{{__('Total Pay')}}:</span>
                                        <span class="uk-text-bold uk-text-primary">{{ Auth::user()->expenses->sum('pay') }}</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="uk-grid-small uk-text-left uk-child-width-expand@s" uk-grid>
                                        <span class="uk-text-muted">{{__('Total Discount')}}:</span>
                                        <span class="uk-text-bold uk-text-primary">{{ Auth::user()->expenses->sum('discount') }}</span>
                                    </div>
                                </li>
                                @php
                                    $remaining = (Auth::user()->expenses->sum('cost') + Auth::user()->classEdu->expenses_cost) - (Auth::user()->expenses->sum('pay') + Auth::user()->expenses->sum('discount'))
                                @endphp
                                <li>
                                    <div class="uk-grid-small uk-text-left uk-child-width-expand@s" uk-grid>
                                        <span class="uk-text-muted">{{__('Remaining')}}:</span>
                                        <span class="uk-text-bold uk-text-success" style="font-weight: 600;">{{ $remaining }}</span>
                                    </div>
                                </li>
                            </ul>
                            <table class="uk-table uk-table-striped" v-if="showExpensesContent == true">
                                    <thead>
                                        <tr>
                                            <th>{{__('Created At')}}</th>
                                            <th>{{__('Pay')}}</th>
                                            <th>{{__('Cost')}}</th>
                                            <th>{{__('Discount')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (Auth::user()->expenses as $item)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($item->created_at)->toFormattedDateString() }}</td>
                                                <td>{{ $item->pay }}</td>
                                                <td>{{ $item->cost }}</td>
                                                <td>{{ $item->discount }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <hr>
                                <span class="show-result uk-text-center">
                                    <a v-if="showExpensesContent == false" @click.prevent="showExpensesContent = true" href="">{{__('Show Table')}}</a>
                                    <a v-if="showExpensesContent == true" @click.prevent="showExpensesContent = false" href="">{{__('Hiden Table')}}</a>
                                </span>
                        </li>
                    <li>
                        <h3 class="uk-margin-small-bottom">{{__('Results')}}.</h3>
                        {{__('Coming soon')}}...</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra-js')
<script src="https://unpkg.com/vue"></script>
    <script>
        const app = new Vue({
            el: '#profile',
            data() {
                return {
                    showContent: false,
                    showPrsonalInfo: false,
                    showAttendContent: false,
                    showExpensesContent: false,
                }
            },
            mesthods: {
            }
        })
    </script>
@endsection