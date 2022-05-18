<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Connection;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
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
            $arr = $connection->produks();
            $collection = Collection::make($arr);
            return view('page.office.product.list',compact('collection'));
        }
        return view('page.office.product.main');
    }
    public function create()
    {
        return view('page.office.product.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'categories_id' => 'required',
            'name' => 'required',
            'weight' => 'required',
            'description' => 'required',
            'price' => 'max:19',
            'stock' => 'max:6',
            'photo' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            // if ($errors->has('categories_id')) {
            //     return response()->json([
            //         'alert' => 'error',
            //         'message' => $errors->first('categories_id'),
            //     ]);
            // } 
            // else
            if ($errors->has('name')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('name'),
                ]);
            } elseif ($errors->has('weight')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('weight'),
                ]);
            } elseif ($errors->has('description')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('description'),
                ]);
            } elseif ($errors->has('price')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('price'),
                ]);
            } elseif ($errors->has('stock')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('stock'),
                ]);
            } else {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('photo'),
                ]);
            }
        }
        try {
            $file = request()->file('photo')->store("product");
            $store = Http::post("127.0.0.1:8001/api/produks", [
                "name" => Str::title($request->name),
                "weight" => $request->weight,
                "description" => $request->description,
                "price" => Str::of($request->price)->replace(',', '') ?: 0,
                "stock" => Str::of($request->stock)->replace(',', '') ?: 0,
                "photo" => $file,
            ]);
            if($store->getStatusCode() == 200){
                return response()->json([
                    'alert' => 'success',
                    'message' => 'Produk ' . $request->name . ' ditambahkan',
                    'response' => $store->getStatusCode(),
                ]);
            }
            return response()->json([
                'alert' => 'error',
                'message' => 'request failed',
                'response' => $store->getStatusCode(),
            ]);
        } catch (ConnectException $e) {
            return response()->json([
                'alert' => 'error',
                'message' => 'Service gagal terkoneksi', 
                'response' => $e
            ]);
        } catch (RequestException $e) {
            if ($e->hasResponse()){
                if ($e->getResponse()->getStatusCode() == '400') {
                        echo "Got response 400" ;
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
    public function show($product)
    {
        //
    }
    public function edit($data)
    {
        try {
            $product = Http::get("127.0.0.1:8001/api/produks/{$data}")->json(['data']);
            $product = (object) $product;
            return view('page.office.product.input', compact('product'));
        } catch (ConnectException $e) {
            return view('errors.503');
        } catch (Exception $e) {
            return view('errors.503');
        }
    }
    public function update(Request $request, $product)
    {
        $validator = Validator::make($request->all(), [
            // 'categories_id' => 'required',
            'name' => 'required',
            'weight' => 'required',
            'description' => 'required',
            'price' => 'max:19',
            'stock' => 'max:6',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            // if ($errors->has('categories_id')) {
            //     return response()->json([
            //         'alert' => 'error',
            //         'message' => $errors->first('categories_id'),
            //     ]);
            // } 
            // else
            if ($errors->has('name')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('name'),
                ]);
            } elseif ($errors->has('weight')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('weight'),
                ]);
            } elseif ($errors->has('description')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('description'),
                ]);
            } elseif ($errors->has('price')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('price'),
                ]);
            } elseif ($errors->has('stock')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('stock'),
                ]);
            }
        }
        $data = Http::get("127.0.0.1:8001/api/produks/{$product}")->json(['data']);
        $item = (object) $data;
        $id = (int) $request->id;
        try {
            $client = new Client([
                'headers' => [
                    'Content-Type' => 'application/json',
                    'apikey'=> config('app._api_key'),
                    'debug' => true
                    ]
                ]);
            $url =  "127.0.0.1:8001/api/produks/{$product}";
            if (request()->file('photo')) {
                Storage::delete($item->photo);
                $file = request()->file('photo')->store("product");
                $body["id"] = $id;
                $body["name"] = Str::title($request->name);
                $body["weight"] = $request->weight;
                $body["description"] = $request->description;
                $body["price"] = Str::of($request->price)->replace(',', '') ?: 0;
                $body["stock"] = Str::of($request->stock)->replace(',', '') ?: 0;
                $body["updated_at"] = now();
                $body["created_at"] = now();
                $body["photo"] = $file;
                $body["user_id"] = 1;
                $body=json_encode($body);
                $response = $client->request('PATCH',$url,['body'=>$body]);
                $URI_Response =json_decode($response->getBody(), true);
                if($response->getStatusCode() == 200){
                    return response()->json([
                        'alert' => 'success',
                        'message' => 'Produk ' . $request->name . ' diubah',
                        'response' => $response->getStatusCode(),
                    ]);
                }
                if ($response->getStatusCode() != 200) {
                    return response()->json([
                        'alert' => 'error',
                        'message' => 'request failed',
                        'response' => $response->getStatusCode(),
                    ]);
                }
            }else{
                $body["id"] = $id;
                $body["name"] = Str::title($request->name);
                $body["weight"] = $request->weight;
                $body["description"] = $request->description;
                $body["price"] = Str::of($request->price)->replace(',', '') ?: 0;
                $body["stock"] = Str::of($request->stock)->replace(',', '') ?: 0;
                $body["photo"] = $request->photo2;
                $body["user_id"] = 1;
                $body=json_encode($body);
                $response = $client->request('PATCH',$url,['body'=>$body]);
                $URI_Response = json_decode($response->getBody(), true);
                if($response->getStatusCode() == 200){
                    return response()->json([
                        'alert' => 'success',
                        'message' => 'Produk ' . $request->name . ' diubah',
                        'response' => $response->getStatusCode(),
                    ]);
                }
                if ($response->getStatusCode() != 200) {
                    return response()->json([
                        'alert' => 'error',
                        'message' => 'request failed',
                        'response' => $response->getStatusCode(),
                    ]);
                }
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
            return response()->json(['alert' => 'error',
                'message' => 'Service sedang bermasalah', 
                'response' => $e
            ]);
        }
    }
    public function destroy($product)
    {
        try {
            $data = Http::get("127.0.0.1:8001/api/produks/{$product}")->json(['data']);
            Http::delete("127.0.0.1:8001/api/produks/{$data['id']}");
            Storage::delete($data['photo']);
            return response()->json([
                'alert' => 'success',
                'message' => 'Product ' . $data['name'] . ' Deleted',
            ]);
         } catch (ConnectException $e) {
            return response()->json([
                'alert' => 'error',
                'message' => 'Service gagal terkoneksi', 
                'response' => $e
            ]);
        } catch (RequestException $e) {
            if ($e->hasResponse()){
                if ($e->getResponse()->getStatusCode() == '400') {
                        echo "Got response 400" ;
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
}
