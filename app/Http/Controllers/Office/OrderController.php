<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Connection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use PDF;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(function($request, $next){
            $session = Session::get('admin');
            // dd($session);
            if(!$session){
                return response()->view('page.office.auth.main');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $connection = new Connection;
            $arr = $connection->orders();
            $collection = Collection::make($arr);
            // $start = $request->start;
            // $end = $request->end;
            // $st = $request->st;
            // $collection = Order::whereBetween(DB::raw('date(created_at)'), [$start, $end])
            // ->where('st', $st)
            // ->orderBy('id','DESC')
            // ->paginate(10);
            return view('page.office.order.list', compact('collection'));
        }
        return view('page.office.order.main');
    }
    public function edit(Order $order)
    {
        return view('page.office.order.input',compact('order'));
    }
    public function update(Request $request, Order $order)
    {
        $order->resi = $request->resi;
        $order->st = "On the way";
        $order->save();
        return response()->json([
            'alert' => 'success',
            'message' => 'No Resi Inserted',
        ]);
    }
    public function reject(Order $order)
    {
        $order->st = "Payment Rejected";
        $order->update();
        return response()->json([
            'alert' => 'success',
            'message' => 'Payment rejected',
        ]);
    }
    public function acc(Order $order){
        $order->st = "Order on process";
        $order->update();
        foreach($order->order_detail AS $order_detail){
            $stock = "stock_".$order_detail->type;
            DB::select(DB::raw("
            update products set $stock = $stock-$order_detail->qty where id = $order_detail->product_id
            "));
        }
        return response()->json([
            'alert' => 'success',
            'message' => 'Payment accepted',
        ]);
    }

}
