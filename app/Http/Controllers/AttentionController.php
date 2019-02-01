<?php

namespace App\Http\Controllers;

use App\Attention;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\AttentionType;

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
            Attention::create([
                'user_id' => $request->user_id,
                'attention_type_id' => $request->type,
                'author_id' => Auth::id(),
                'end_date' => $request->end_date,
                'body' => $request->body,
            ]);

            return 'Item has been add!';
        } else {
            return 'You are not a method post!';
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
