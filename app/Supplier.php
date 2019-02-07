<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Supplier extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * Show the User Has Many DuePayment.
     *
     * @return App\DuePayment
     */
    public function duePayments()
    {
        return $this->hasMany('App\DuePayment', 'supplier_id');
    } 

    /**
     * Get all of the Storages for the country.
     */
    public function storages()
    {
        return $this->hasManyThrough('App\Storage', 'App\DuePayment');
    }

    public function delete()
    {
        // delete all related photos 
        $this->duePayments()->delete();
        $this->storages()->delete();
        // as suggested by Dirk in comment,
        // it's an uglier alternative, but faster
        // Photo::where("user_id", $this->id)->delete()

        // delete the user
        return parent::delete();
    }
}
