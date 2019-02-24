<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\AttentionGroupType;
use App\AttentionGroup;

class HomeworkAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($username, $id = null)
    {
        $attentionTypes = AttentionGroupType::all();
        $attentions = AttentionGroup::with('attentionType')->where('classroom_id', Auth::user()->classroom_id)->orderBy('id', 'DESC')->get();
        $attentionsClass = AttentionGroup::with('attentionType')->where('classroom_id', null)->where('class_id', Auth::user()->class_id)->orderBy('id', 'DESC')->get();
        $attentionsStage = AttentionGroup::with('attentionType')->where('classroom_id', null)->where('class_id', Auth::user()->class_id)->where('stage_id', Auth::user()->stage_id)->orderBy('id', 'DESC')->get();

        $attentionType = AttentionGroup::where(function ($query) use($id) {
            $query->where('attention_group_type_id', $id)->where('classroom_id', Auth::user()->classroom_id);
        })->get();
        $attentionTypeClass = AttentionGroup::where(function ($query) use($id) {
            $query->where('attention_group_type_id', $id)->where('classroom_id', null)->where('class_id', Auth::user()->class_id);
        })->get();
        $attentionTypeStage = AttentionGroup::where(function ($query) use($id) {
            $query->where('attention_group_type_id', $id)->where('classroom_id', null)->where('class_id', null)->where('stage_id', Auth::user()->stage_id);
        })->get();

        return view('vendor.frontend.account.homework', [
            'attentionTypes' => $attentionTypes,
            'attentionType' => $attentionType,
            'attentions' => $attentions,
            'attentionsClass' => $attentionsClass,
            'attentionsStage' => $attentionsStage,
            'attentionTypeClass' => $attentionTypeClass,
            'attentionTypeStage' => $attentionTypeStage,
        ]);
    }

}
