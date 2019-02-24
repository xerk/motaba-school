<?php

namespace App\Observers;

use App\AddSalary;

class AddSalaryObserver
{
    /**
     * Handle the add salary "created" event.
     *
     * @param  \App\AddSalary  $addSalary
     * @return void
     */
    public function creating(AddSalary $addSalary)
    {
        $addSalary->absent_day = 5;
    }

    public function created(AddSalary $addSalary)
    {
        $addSalary->absent_day = 5;
    }
    public function create(AddSalary $addSalary)
    {
        $addSalary->absent_day = 5;
    }

    /**
     * Handle the add salary "updated" event.
     *
     * @param  \App\AddSalary  $addSalary
     * @return void
     */
    public function updated(AddSalary $addSalary)
    {
        $addSalary->absent_day = 5;
    }

    /**
     * Handle the add salary "updated" event.
     *
     * @param  \App\AddSalary  $addSalary
     * @return void
     */
     public function saving(AddSalary $addSalary)
     {
         $addSalary->absent_day = 5;
     }

     /**
     * Handle the add salary "updated" event.
     *
     * @param  \App\AddSalary  $addSalary
     * @return void
     */
    public function saved(AddSalary $addSalary)
    {
        $addSalary->absent_day = 5;
    }

    /**
     * Handle the add salary "updated" event.
     *
     * @param  \App\AddSalary  $addSalary
     * @return void
     */
     public function save(AddSalary $addSalary)
     {
         $addSalary->absent_day = 5;
     }

    /**
     * Handle the add salary "deleted" event.
     *
     * @param  \App\AddSalary  $addSalary
     * @return void
     */
    public function deleted(AddSalary $addSalary)
    {
        //
    }

    /**
     * Handle the add salary "restored" event.
     *
     * @param  \App\AddSalary  $addSalary
     * @return void
     */
    public function restored(AddSalary $addSalary)
    {
        //
    }

    /**
     * Handle the add salary "force deleted" event.
     *
     * @param  \App\AddSalary  $addSalary
     * @return void
     */
    public function forceDeleted(AddSalary $addSalary)
    {
        //
    }
}
