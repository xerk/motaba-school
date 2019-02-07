<?php

namespace App\Http\Controllers;

use App\User;
use App\SmsLog;
use App\Attention;
use App\AttentionType;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Query\Builder;

class AttentionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $browes = Voyager::canOrFail('browse_attentions');
        return view('vendor.voyager.attentions.attentions');
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
        if($request->isMethod('post')) {
            $http = new Client;
            try {
                Attention::create([
                    'user_id' => $request->user_id,
                    'attention_type_id' => $request->type,
                    'author_id' => Auth::id(),
                    'end_date' => $request->end_date,
                    'body' => $request->body,
                    'sms' => $request->sms,
                ]);
                $user = User::where('id', $request->user_id)->first();
                if ($user->job == 1) {
                    $response = $http->post(env('SMS_LINK'), [
                        'query' => [
                            'username' => env('SMS_USERNAME'),
                            'password' => env('SMS_PASSWORD'),
                            'sender' => env('SMS_SENDER'),
                            'language' => 2,
                            'mobile' => '2'.$user->father_mobile,
                            'message' => $request->sms,
                            'DelayUntil' => Carbon::now()->toDateString()
                        ]
                    ]);
                } else {
                    $response = $http->post(env('SMS_LINK'), [
                        'query' => [
                            'username' => env('SMS_USERNAME'),
                            'password' => env('SMS_PASSWORD'),
                            'sender' => env('SMS_SENDER'),
                            'language' => 2,
                            'mobile' => $user->mobile,
                            'message' => $request->sms,
                            'DelayUntil' => Carbon::now()->toDateString()
                        ]
                    ]);
                }
                
                $data = json_decode($response->getBody());
                // retrun json_decode((string)) $response->getBody(), true);
                if ($data->code == 1901) {
                    SmsLog::create([
                        'amount' => 1,
                        'success_send' => 1,
                        'fail_send' => 0,
                        'type' => 'رسائل نصية لتنبيه الطالب أو الموظف',
                    ]);
                    if ($user->job == 0) {
                        return response()->json('Attention & SMS has been sent to '.$user->mobile, 200);
                    } else {
                        return response()->json('Attention & SMS has been sent to '.$user->father_mobile, 200);
                    }
                } else {
                    SmsLog::create([
                        'amount' => 1,
                        'success_send' => 0,
                        'fail_send' => 1,
                        'type' => 'رسائل نصية لتنبيه الطالب أو الموظف',
                    ]);
                    return $response->getBody();
                }

            } catch (\GuzzleHttp\Exception\BadResponseException $e) {
                if($e->getCode() === 400) {
                    return response()->json('Invalid Request.', $e->getCode());
                } else if ($e->getCode() === 401) {
                    return response()->json('Your username and passowrd are incorrect', $e->getCode());
                }
                return response()->json('Sms is empty', $e->getCode());
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Attention  $attention
     * @return \Illuminate\Http\Response
     */
    public function show(Attention $attention)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attention  $attention
     * @return \Illuminate\Http\Response
     */
    public function edit(Attention $attention)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attention  $attention
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attention $attention)
    {
        $attention = Attention::find($request->id);
        $attention->author_id = Auth::id();
        $attention->end_date = $request->end_date;
        $attention->attention_type_id = $request->type;
        $attention->body = $request->body;
        $attention->sms = $request->sms;
        $attention->save();

        return response('Attention has been updated!', 200); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attention  $attention
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Attention::where('id', $id)->delete();

        return response('Attention has beend deleted.', 200);
    }

    public function getStudents(Request $request)
    {
        $users = User::withCount('attentions')->get();
        $types = AttentionType::all();
        $author = Auth::user();

        if ($request->attentionGet) {
            $attention = Attention::where('id', $request->attentionGet)->with('users', 'attentionTypes', 'authors')->first();
        } else {
            $attention = null;
        }

        if ($request->id) {
            $attentions = Attention::where('user_id', $request->id)->with('users', 'attentionTypes', 'authors')->get();
            $user = User::find($request->id);            
        } else {
            $user = null;
            $attentions = null;
        }
        return [
            'users' => $users,
            'user' => $user,
            'types' => $types,
            'attentions' => $attentions,
            'author' => $author,
            'attention' => $attention,
        ];
    }
}
