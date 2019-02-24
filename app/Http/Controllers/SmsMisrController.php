<?php

namespace App\Http\Controllers;

use App\User;
use App\SmsLog;
use App\Attendance;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use TCG\Voyager\Facades\Voyager;

class SmsMisrController extends Controller
{
    private $username;
	private $password;
	private $sender;
	private $link;
	private $mobile;
	function __construct()
	{

		$this->username = env('SMS_USERNAME');
		$this->password = env('SMS_PASSWORD');
		$this->sender = env('SMS_SENDER');
		$this->link = env('SMS_LINK');
		$this->mobile = env('OWNER_MOBILES');
    }

    /**
     * Send data api Vue files
     * @return \SmsMisr Config
     * in Function smsAPI
     */

    public function smsApi()
    {
        $browes = Voyager::canOrFail('browse_admin');
        return [
            'smsMisr' => [
                'username' => $this->username,
                'password' => $this->password,
                'sender' => $this->sender,
                'link' => $this->link,
                'mobile' => $this->mobile,
            ]
        ];
    }

    public function storeAttendance(Request $request)
    {
        if ($request->classRoom != '') {
            $date = Carbon::now()->addDays($request->day);
            $count = Attendance::where(function($query) use ($date, $request) {
                $query->where('status', 3)->where('attend_date', $date->toDateString())->where('sms_status', '=', null)->whereHas('users', function ($q) use ($request) {
                    $q->where('job', '=', 1);
                    $q->where('classroom_id', '=', $request->classRoom);
                });
            })->count();
            $countNotNullPhone = Attendance::where(function($query) use ($date, $request) {
                $query->where('status', 3)->where('attend_date', $date->toDateString())->whereHas('users', function ($q) use ($request) {
                    $q->where('job', '=', 1);
                    $q->where('classroom_id', '=', $request->classRoom);
                    $q->where('father_mobile', '<>', '');
                });
            })->count();
            $countNullPhone = Attendance::where(function($query) use ($date, $request) {
                $query->where('status', 3)->where('attend_date', $date->toDateString())->whereHas('users', function ($q) use ($request) {
                    $q->where('job', '=', 1);
                    $q->where('classroom_id', '=', $request->classRoom);
                    $q->where('father_mobile', '=', '');
                });
            })->count();
            $attends = User::where(function($query) use ($request) {
                    $query->where('classroom_id', '=', $request->classRoom)
                        ->where('job', '=', 1);
                })->WhereHas('attendance', function ($query) use ($date, $request) {
                    $query->where('status', 3)->where('attend_date', $date->toDateString());
                })->with(['attendance' => function ($query) use ($date, $request) {
                    $query->where('status', 3)->where('attend_date', $date->toDateString());
                }])->get();

                $sms_statusDeAcitve = Attendance::where(function($query) use ($date, $request) {
                    $query->where('status', 3)->where('attend_date', $date->toDateString())->where('sms_status', '=', null)->whereHas('users', function ($q) use ($request) {
                        $q->where('job', '=', 1);
                        $q->where('classroom_id', '=', $request->classRoom);
                    });
                })->get();

            // $attendCount = $attends->count();
            // dd([implode(', ', $attends->pluck('father_mobile')->toArray())]);
            if ($count != 0) {
                // if ($attendCount > 0) {
                    // Right Post Command
                    if ($date->toDateString() <= Carbon::now()) {
                        $http = new Client;
                        try {
                            $response = $http->post($this->link, [
                                'headers' => [
                                    'User-Agent' => 'testing/1.0',
                                    'Accept'     => 'application/json',
                                    'X-Foo'      => ['Bar', 'Baz']
                                ],
                                'query' => [
                                    'username' => $this->username,
                                    'password' => $this->password,
                                    'sender' => $this->sender,
                                    'language' => 2,
                                    'mobile' => implode(', ', $attends->pluck('father_mobile')->toArray()),
                                    'message' => 'نحيط علم سيادتكم أنه قد تغيب الطالب اليوم - معهد كامل عودة الأزهرى',
                                    'DelayUntil' => Carbon::now()->toDateString()
                                ]
                            ]);
                            foreach ($sms_statusDeAcitve as $key => $attend) {
                                $attendance = Attendance::find($attend->id);
                                $attendance->sms_status = 1;
                                $attendance->save();
                            }
                            $data = json_decode($response->getBody());

                            if ($data->code == 1901) {
                                SmsLog::create([
                                    'amount' => $count,
                                    'success_send' => $countNotNullPhone,
                                    'fail_send' => $countNullPhone,
                                    'type' => 'رسائل نصية لغياب الطلاب',
                                    'class_room_id' => $request->classRoom
                                ]);
                                return $response->getBody();
                            } else {
                                SmsLog::create([
                                    'amount' => $count,
                                    'success_send' => '0',
                                    'fail_send' => $count,
                                    'type' => 'رسائل نصية لغياب الطلاب',
                                    'class_room_id' => $request->classRoom
                                ]);
                                return $response->getBody();
                            }
                            // retrun json_decode((string)) $response->getBody(), true);

                        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
                            if($e->getCode() === 400) {
                                return response()->json('Invalid Request.', $e->getCode());
                            } else if ($e->getCode() === 401) {
                                return response()->json('Your username and passowrd are incorrect', $e->getCode());
                            }
                            return response()->json('Something went wrong on the server', $e->getCode());
                        }
                        // return $attends;
                    } else {
                        return __('Can\'t Send SMS the next date of day.');
                    }
                // } else {
                //     return 'Member is empty!';
                // }
            } else {
                return __('You do not have students absent here!');
            }
        } else {
            return __('Please Choose the display student.');
        }
    }
    public function storeEAttendance(Request $request)
    {
            $date = Carbon::now()->addDays($request->day);

            $count = Attendance::where(function($query) use ($date) {
                $query->where('status', 3)->where('attend_date', $date->toDateString())->whereHas('users', function ($q) {
                    $q->where('job', '=', 0);
                });
            })->count();
            $countNullPhone = Attendance::where(function($query) use ($date) {
                $query->where('status', 3)->where('attend_date', $date->toDateString())->whereHas('users', function ($q) {
                    $q->where('job', '=', 0);
                    $q->where('mobile', '=', '');
                });
            })->count();
            $countNotNullPhone = Attendance::where(function($query) use ($date) {
                $query->where('status', 3)->where('attend_date', $date->toDateString())->whereHas('users', function ($q) {
                    $q->where('job', '=', 0);
                    $q->where('mobile', '<>', '');
                });
            })->count();

            $attends = User::where('job', 0)->WhereHas('attendance', function ($query) {
                $query->where('status', 3);
            })->with(['attendance' => function ($query) {
                $query->where('status', 3);
            }])->get();

            // $attendCount = $attend->count();
            // dd($attendCount);

            if ($count != 0) {
                    // Right Post Command
                    if ($date->toDateString() <= Carbon::now()) {
                        $http = new Client;

                        try {
                            $response = $http->post($this->link, [
                                'query' => [
                                    'username' => $this->username,
                                    'password' => $this->password,
                                    'sender' => $this->sender,
                                    'language' => 1,
                                    'mobile' => implode(', ', $attends->pluck('father_mobile')->toArray()),
                                    'message' => 'Hello',
                                    'DelayUntil' => Carbon::now()->toDateString()
                                ]
                            ]);

                            $data = json_decode($response->getBody());
                            // retrun json_decode((string)) $response->getBody(), true);
                            if ($data->code == 1901) {
                                SmsLog::create([
                                    'amount' => $count,
                                    'success_send' => $countNotNullPhone,
                                    'fail_send' => $countNullPhone,
                                    'type' => 'رسائل نصية لغياب الموظفين',
                                ]);
                                return $response->getBody();
                            } else {
                                SmsLog::create([
                                    'amount' => $count,
                                    'success_send' => '0',
                                    'fail_send' => $count,
                                    'type' => 'رسائل نصية لغياب الموظفين',
                                ]);
                                return $response->getBody();
                            }

                        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
                            if($e->getCode() === 400) {
                                return response()->json('Invalid Request.', $e->getCode());
                            } else if ($e->getCode() === 401) {
                                return response()->json('Your username and passowrd are incorrect', $e->getCode());
                            }
                            return response()->json('Something went wrong on the server', $e->getCode());
                        }
                        // return $attends;

                    } else {
                        return __('Can\'t Send SMS the next date of day.');
                    }

            } else {
                return __('You do not have students absent here!');
            }


    }
}
