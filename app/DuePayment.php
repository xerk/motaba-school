<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class DuePayment extends Model
{
    protected $fillable = [
        'supplier_id', 'payable', 'title', 'comment',
    ];

    /**
     * Show the User Has Many Storages.
     *
     * @return App\Storage
     */
    public function storages()
    {
        return $this->hasMany('App\Storage');
    }

    /**
     * Show the User Belongs To Supplier.
     *
     * @return App\Supplier
     */
    public function supplier()
    {
        return $this->belongsTo('App\Supplier', 'supplier_id', 'id');
    }

    static function boot()
    {
        DuePayment::deleting(function ($duePayment) {
            $duePayment->storages()->delete();
        });
    }
}
