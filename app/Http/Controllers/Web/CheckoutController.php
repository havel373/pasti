<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Connection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Models\Province;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function index()
    {

        $connection = new Connection;
        $arr = $connection->orders();
        $collection = Collection::make($arr);
        return view('page.web.checkout.main', compact('collection'));
    }

    public function create(Request $request , $id){
        try {
            $arr = Http::get("127.0.0.1:8001/api/produks/{$id}");
            $arr = json_decode($arr);
            $product = $arr->data;
            $quantity = $request->quantity;
            if($product->stock < $quantity) {
                Session::flash('message', "Stok tidak mencukupi");
                return Redirect::back();
            }
            return view('page.web.checkout.form',compact('product', 'quantity'));
        } catch (ConnectException $e) {
            return view('errors.503');
        } catch (RequestException $e) {
            if ($e->hasResponse()){
                if ($e->getResponse()->getStatusCode() == '400') {
                        echo "Got response 400" ;
                }
            }
        }catch (Exception $e) {
            return view('errors.503');
        }
    }

    public function add(Request $request){
        try {
            $arr = Http::get("127.0.0.1:8001/api/produks/{$request->product_id}");
            $arr = json_decode($arr);
            $produk = $arr->data;
        } catch (ConnectException $e) {

        } catch (Exception $e) {

        }
        $product = (int) $request->product_id;
        $id = (int) $request->user_id;
        try {
            $client = new Client([
                'headers' => [
                    'Content-Type' => 'application/json',
                    'apikey'=> config('app._api_key'),
                    'debug' => true
                    ]
                ]);
            $file = request()->file('photo')->store("bukti_tf");
            $url =  'http://127.0.0.1:8003/api/orders';
            $body['user_id'] = $id;
            $body['product_id']= $product;
            $body['address']= $request->address;
            $body['postcode']= $request->postcode;
            $body['photo']= $file;
            $body['status']= 'waiting';
            $body['resi']= '12321321321';
            $body['ongkir']= '20000';
            $body['total']= $request->total;
            $body['notes']= $request->notes;
            $body=json_encode($body);
            $response = $client->request('POST',$url,['body'=>$body]);
            $URI_Response =json_decode($response->getBody(), true);
            if($response->getStatusCode() == 200){
                return response()->json([
                    'alert' => 'success',
                    'message' => 'Pesanan anda berhasil ditambahkan',
                    'response' => $response->getStatusCode(),
                    'redirect' => route('web.home')
                ]);
            }
            if ($response->getStatusCode() != 200) {
                return response()->json([
                    'alert' => 'error',
                    'message' => 'request failed',
                    'response' => $response->getStatusCode(),
                ]);
            }
        } catch (ConnectException $e) {
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
            return response()->json([
                'alert' => 'error',
                'message' => 'Service sedang bermasalah', 
                'response' => $e
            ]);
        }
    }
    public function store(Request $request)
    {
        $token = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'quantity' => 'required',
            'size' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('quantity')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('quantity'),
                ]);
            } elseif ($errors->has('size')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('size'),
                ]);
            }
        }
       
    }
    public function destroy( $cart)
    {
        $cart->delete();
        return response()->json([
            'alert' => 'success',
            'message' => 'Cart ' . $cart->product->titles . ' Deleted',
        ]);
    }
}
