<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Connection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
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
    public function edit($order)
    {
        return view('page.office.order.input',compact('order'));
    }
    public function update(Request $request, $order)
    {
        $order->resi = $request->resi;
        $order->st = "On the way";
        $order->save();
        return response()->json([
            'alert' => 'success',
            'message' => 'No Resi Inserted',
        ]);
    }
    public function reject($order)
    {
        $connection = new Connection;
        $collection = $connection->ordersCollection();
        $body = $collection->where('id', $order)->first();
        dd($body);
        $data = json_decode(collect($body));
        dd($data->);
        try{
            $url = "127.0.0.1:8003/api/orders";
            $client = new Client([
                'headers' => [
                    'Content-Type' => 'application/json',
                    'apikey'=> config('app._api_key'),
                    'debug' => true
                    ]
                ]);
            $body['status'] = "Payment Rejected";
            $response = $client->request('PATCH',$url,['body'=>$body]);
            dd($response->getStatusCode());
            $URI_Response =json_decode($response->getBody(), true);
            if($response->getStatusCode() == 200){
                return response()->json([
                    'alert' => 'success',
                    'message' => 'Payment rejected',
                ]);
            }else{
                return response()->json([
                    'alert' => 'error',
                    'message' => 'request failed',
                    'response' => $response->getStatusCode(),
                ]);
            }

        }  catch (ConnectException $e) {
            return response()->json([
                'alert' => 'error',
                'message' => 'Service gagal terkoneksi', 
                'response' => $e
            ]);
        } catch (RequestException $e) {
            if ($e->hasResponse()){
                if ($e->getResponse()->getStatusCode() == '400') {
                        echo "Got response 400" . dd($e);
                }
            }
        }catch (Exception $e) {
            return response()->json(['alert' => 'error',
                'message' => 'Service sedang bermasalah', 
                'response' => $e
            ]);
        }
    }
    public function acc($order){
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
