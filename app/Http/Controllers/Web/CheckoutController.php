<?php

namespace App\Http\Controllers\Web;

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
        return view('page.web.checkout.main');
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
            // dd($e);
        } catch (Exception $e) {
            // return $e;
            // dd($e);
        }
        $request->total;
        $qty = $produk->stock - $request->total;
        $product_ids = (int) $request->product_id;
        $store = Http::patch("127.0.0.1:8001/api/produks/{$request->product_id}", [
            "id" => $product_ids,
            "stock" => $qty
        ]);
        dd($store->getStatusCode());
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
            $body['user_id'] = $product;
            $body['product_id']= $id;
            $body['address']= $request->address;
            $body['postcode']= $request->postcode;
            $body['photo']= $file;
            $body['status']= 'waiting';
            // $body['resi']= '12321321321';
            $body['ongkir']= '20000';
            $body['total']= $request->total;
            $body['notes']= $request->notes;
            // $body['user_id'] = $id;
            // $body['product_id']= $product;
            // $body['address']= $request->address;
            // $body['postcode']= $request->postcode;
            // $body['photo']= $file;
            // $body['status']= 'waiting';
            // $body['resi']= '12321321321';
            // $body['ongkir']= '20000';
            // $body['total']= $request->total;
            // $body['notes']= $request->notes;
            $body=json_encode($body);
            $response = $client->request('POST',$url,['body'=>$body]);
            $URI_Response =json_decode($response->getBody(), true);
            // $arr = $client->request('POST', 'http://127.0.0.1:8003/api/orders', [
            //     'form_params' => [
            //        'ID' => 12,
            //         //'user_id' => Session::get('id'),
            //         //'product_id' => $request->product,
            //         //'total' => $request->quantity
            //        'user_id' => 2,
            //        'product_id'=> 4,
            //        'address'=>'jalanan',
            //        'postcode'=>'23123',
            //        'photo'=>'test.png',
            //        'status'=>'waiting',
            //        'resi'=>'12321321321',
            //        'ongkir'=>'250000',
            //        'total'=>'3',
            //        'notes'=>'cepat'    
            //     ],
            //     'headers' => [
            //         'Content-Type' => 'application/raw',
            //     ],
            // ]);
        //     if ($arr->getStatusCode() != 200) {
        //         throw new \Exception('Error with status code: ' . $arr->getStatusCode() . 'and body: ' . $arr->getBody()->getContents());
        //       }
            if($response->getStatusCode() == 200){
                return response()->json([
                    'alert' => 'success',
                    'message' => 'Produk ' . $request->name . ' ditambahkan',
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
