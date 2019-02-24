<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class AttentionGroupType extends Model
{
    protected $table = 'attention_group_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'body'
    ];

    /**
     * Show the Attention Belongs To AttentionType.
     *
     * @return App\AttentionType
     */
    public function attentionGroups()
    {
        return $this->hasMany('App\AttentionGroup', 'attention_group_type_id');
    }
}
