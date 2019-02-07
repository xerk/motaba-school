<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Storage extends Model
{
    protected $fillable = [
        'due_payment_id', 'user_id', 'value', 'comment', 'type', 'payable',
    ];
}
