<?php

namespace App\Widgets;

use App\Expense;
use App\Storage;
use App\MakePayment;
use Illuminate\Support\Str;
use TCG\Voyager\Facades\Voyager;
use Arrilot\Widgets\AbstractWidget;
use TCG\Voyager\Widgets\BaseDimmer;
use Illuminate\Support\Facades\Auth;

class SupplierDimmer extends BaseDimmer
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $sum = Storage::sum('value');
        $string = trans_choice('voyager::dimmer.storage', $sum);

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-dollar',
            'title'  => "{$sum} {$string}",
            'text'   => __('voyager::dimmer.storage_text', ['sum' => $sum, 'string' => Str::lower($string)]),
            'button' => [
                'text' => __('voyager::dimmer.page_link_text_state'),
                'link' => '#',
            ],
            'image' => asset('images/widget-backgrounds/expenses.jpg'),
        ]));
    }

    /**
     * Determine if the widget should be displayed.
     *
     * @return bool
     */
    public function shouldBeDisplayed()
    {
        return Auth::user()->can('browse', Voyager::model('User'));
    }
}
