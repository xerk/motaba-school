<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class AttentionGroup extends Model
{
    protected $table = 'attention_groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'stage_id', 'class_id', 'classroom_id', 'attention_group_type_id', 'author_id', 'end_date', 'body', 'amount'
    ];

    /**
     * Show the AttentionGroup Belongs To AttentionGroupType.
     *
     * @return App\AttentionGroupType
     */
    public function attentionType()
    {
        return $this->belongsTo('App\AttentionGroupType', 'attention_group_type_id');
    }

     /**
     * Show the AttendanceGroup Belongs To StageEdu.
     *
     * @return App\Configs\StageEdu
     */
    public function stageEdu()
    {
        return $this->belongsTo('App\Configs\StageEdu', 'stage_id');
    }

    /**
     * Show the AttendanceGroup Belongs To ClassEdu.
     *
     * @return App\Configs\ClassEdu
     */
    public function classEdu()
    {
        return $this->belongsTo('App\Configs\ClassEdu', 'class_id');
    }

    /**
     * Show the AttendanceGroup Belongs To ClassRoom.
     *
     * @return App\Configs\ClassRoom
     */
    public function classRoom()
    {
        return $this->belongsTo('App\Configs\ClassRoom', 'classroom_id');
    }

    /**
     * Show the AttendanceGroup Belongs To User.
     *
     * @return App\User
     */
    public function author()
    {
        return $this->belongsTo('App\User', 'author_id', 'id');
    }
}
