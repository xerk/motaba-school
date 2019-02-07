<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class SmsLog extends Model
{
    protected $fillable = [
        'amount', 'success_send', 'fail_send', 'type', 'class_room_id'
    ];
}
