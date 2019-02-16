<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AttentionType;
use App\Attention;
use Illuminate\Support\Facades\Auth;

class AttentionAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($username, $id = null)
    {
        $attentionTypes = AttentionType::with(['attention' => function($query) {
            $query->where('user_id', '=', Auth::user()->id);
        }])->get();
        $attentions = Attention::with('attentionTypes')->where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->get();
        // dd($attentions);
        $attentionType = Attention::where(function ($query) use($id) {
            $query->where('attention_type_id', $id)->where('user_id', Auth::user()->id);
        })->get();

        return view('vendor.frontend.account.attention', [
            'attentionTypes' => $attentionTypes,
            'attentionType' => $attentionType,
            'attentions' => $attentions
        ]);
    }

}
