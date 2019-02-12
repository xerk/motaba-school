<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use TCG\Voyager\Facades\Voyager;
use Illuminate\Support\Facades\DB;
use App\Storage;
use App\DuePayment;

class SupplierController extends Controller
{

    private $username;
	private $password;
	private $sender;
	function __construct()
	{
		$this->username = env('SMS_USERNAME');
		$this->password = env('SMS_PASSWORD');
		$this->sender = env('SMS_SENDER');
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pay()
    {
        $browes = Voyager::canOrFail('pay_suppliers');
        return view('vendor.voyager.suppliers.pay');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DuePayment::create([
            'supplier_id' => $request->supplier_id,
            'payable' => $request->model['value'],
            'title' => $request->model['title'],
            'comment' => $request->model['comment'],
        ]);
        return 'Due Payment has been added';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeShow(Request $request)
    {
        Storage::create([
            'due_payment_id' => $request->due_payment_id,
            'value' => $request->model['value'],
            'comment' => $request->model['comment'],
            'type' => 2,
        ]);
        return 'Storage has been added';
    }

    public function destroy($id) 
    {
        DuePayment::where('id', $id)->delete();

        return response('Due Payment has beend deleted.', 200);
    }

    public function destroyShow($id) 
    {
        Storage::where('id', $id)->delete();

        return response('Storage has beend deleted.', 200);
    }

    public function getSupplier(Request $request)
    {
        $supplier = Supplier::withCount(['storages' => function ($query) {
            $query->select(DB::raw("SUM(value)"));
        }])->find($request->id);
        $duePayments = DuePayment::with('supplier', 'storages')->withCount(['storages as sum_value' => function ($query) {
            $query->select(DB::raw("SUM(value)"));
        }])->where('supplier_id', $request->id)->get();
        $sumPayable = DuePayment::where('supplier_id', $request->id)->sum('payable');
        
        return [
            'supplier' => $supplier,
            'duePayments' => $duePayments,
            'sumPayable' => $sumPayable
        ];
    }

    public function getStorage(Request $request)
    {
        $duePayments = DuePayment::with('supplier', 'storages')->withCount(['storages as sum_value' => function ($query) {
            $query->select(DB::raw("SUM(value)"));
        }])->where('id', $request->id)->first();
        
        return [
            'duePayments' => $duePayments,
        ];
    }
}
