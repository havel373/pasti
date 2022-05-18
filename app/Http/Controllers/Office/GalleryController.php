<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Connection;
use App\Http\Controllers\Controller;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
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
            $arr = $connection->gallery();
            $collection = Collection::make($arr);
            return view('page.office.gallery.list',compact('collection'));
        }
        return view('page.office.gallery.main');
    }
    public function create()
    {
        return view('page.office.gallery.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'categories_id' => 'required',
            'nama' => 'required',
            'nim' => 'required',
            'email' => 'required',
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
            if ($errors->has('nama')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('nama'),
                ]);
            } elseif ($errors->has('nim')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('nim'),
                ]);
            } elseif ($errors->has('email')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('email'),
                ]);
            } elseif ($errors->has('photo')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('photo'),
                ]);
            }
        }
        try {
            $file = request()->file('photo')->store("gallery");
            $store = Http::post("127.0.0.1:8004/api/gallery", [
                "nama" => Str::title($request->nama),
                "nim" => $request->nim,
                "email" => $request->email,
                "photo" => $file,
            ]);
            if($store->getStatusCode() == 201){
                return response()->json([
                    'alert' => 'success',
                    'message' => 'Gallery ' . $request->nama . ' ditambahkan',
                    'response' => $store->getStatusCode(),
                ]);
            }
            if($store->getStatusCode() == 422){
                return response()->json([
                    'alert' => 'error',
                    'message' => 'kolom email atau nim sudah dipakai ',
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
    public function show()
    {
        //
    }
    public function edit($data)
    {
        try {
            $gallery = Http::get("127.0.0.1:8004/api/gallery/{$data}");
            $gallery =  json_decode($gallery, true);
            $gallery = $gallery['data'][0];
            return view('page.office.gallery.input', compact('gallery'));
        } catch (ConnectException $e) {
            return view('errors.503');
        } catch (Exception $e) {
            return view('errors.503');
        }
    }
    public function update(Request $request, $gallery)
    {
        $validator = Validator::make($request->all(), [
            // 'categories_id' => 'required',
            'nama' => 'required',
            'nim' => 'required',
            'email' => 'required',
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
            if ($errors->has('nama')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('nama'),
                ]);
            } elseif ($errors->has('nim')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('nim'),
                ]);
            } elseif ($errors->has('email')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('email'),
                ]);
            } 
        }
        $data = Http::get("127.0.0.1:8004/api/gallery/{$gallery}")->json(['data']);
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
            $url =  "127.0.0.1:8004/api/gallery/{$gallery}";
            if (request()->file('photo')) {
                $file = request()->file('photo')->store("gallery");
                Storage::delete($request->photo);
                $body["nama"] = Str::title($request->nama);
                $body["nim"] = $request->nim;
                $body["email"] = $request->email;
                $body["photo"] = $file;
                $body=json_encode($body);
                $response = $client->request('PATCH',$url,['body'=>$body]);
                $URI_Response =json_decode($response->getBody(), true);
                if($response->getStatusCode() == 422){
                    return response()->json([
                        'alert' => 'error',
                        'message' => 'kolom email atau nim sudah dipakai ',
                        'response' => $response->getStatusCode(),
                    ]);
                }
                if($response->getStatusCode() == 201){
                    return response()->json([
                        'alert' => 'success',
                        'message' => 'Gallery ' . $request->name . ' diubah',
                        'response' => $response->getStatusCode(),
                    ]);
                }
                if ($response->getStatusCode() != 201) {
                    return response()->json([
                        'alert' => 'error',
                        'message' => 'request failed',
                        'response' => $response->getStatusCode(),
                    ]);
                }
            }else{
                $body["nama"] = Str::title($request->nama);
                $body["nim"] = $request->nim;
                $body["email"] = $request->email;
                $body=json_encode($body);
                $response = $client->request('PATCH',$url,['body'=>$body]);
                $URI_Response = json_decode($response->getBody(), true);
                 if($response->getStatusCode() == 422){
                    return response()->json([
                        'alert' => 'error',
                        'message' => 'kolom email atau nim sudah dipakai ',
                        'response' => $response->getStatusCode(),
                    ]);
                }
                if($response->getStatusCode() == 201){
                    return response()->json([
                        'alert' => 'success',
                        'message' => 'Gallery ' . $request->name . ' diubah',
                        'response' => $response->getStatusCode(),
                    ]);
                }
                if ($response->getStatusCode() != 201) {
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
    public function destroy($gallery)
    {
        // try {
            $item = Http::get("127.0.0.1:8004/api/gallery/{$gallery}")->json(['data']);
            $data = $item[0];     
            Http::delete("127.0.0.1:8004/api/gallery/{$data['id']}");
            Storage::delete($data['photo']);
            return response()->json([
                'alert' => 'success',
                'message' => 'Gallery ' . $data['nama'] . ' Terhapus',
            ]);
        //  } catch (ConnectException $e) {
        //     return response()->json([
        //         'alert' => 'error',
        //         'message' => 'Service gagal terkoneksi', 
        //         'response' => $e
        //     ]);
        // } catch (RequestException $e) {
        //     if ($e->hasResponse()){
        //         if ($e->getResponse()->getStatusCode() == '400') {
        //                 echo "Got response 400" ;
        //         }
        //     }
        // }catch (Exception $e) {
        //     return response()->json([
        //         'alert' => 'error',
        //         'message' => 'Service sedang bermasalah', 
        //         'response' => $e
        //     ]);
        // }
    }
}
