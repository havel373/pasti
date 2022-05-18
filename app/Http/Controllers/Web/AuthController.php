<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Province;
use App\Models\User;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'edit_profile', 'update_profile', 'do_logout');
    }
    public function index()
    {
        return view('page.web.auth.main');
    }
    public function do_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('email')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('email'),
                ]);
            } else {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('password'),
                ]);
            }
        }
        try {

            $check = Http::post("127.0.0.1:8002/api/auth/login",[
                'email' => $request->email,
                'password'  => $request->password,
                'role' => 'user'
            ]);
            if($check->getStatusCode() == 200){
                $role = json_decode($check->getBody())->data->role;
                if($role != 'user'){
                    return response()->json([
                        'alert' => 'error',
                        'message' => 'Akun anda bukan user!', 
                        'response' => $check->getStatusCode(),
                    ]);
                }
                $collection = json_decode($check->getBody());
                Session::put('token' , $collection->data->token);
                Session::put('id' , $collection->data->id);
                Session::put('name' , $collection->data->name);
                Session::put('email' , $collection->data->email);
                Session::put('role' , $collection->data->role);
                Session::put('phone' , $collection->data->phone);
                return response()->json([
                    'alert' => 'success',
                    'message' => 'Selamat Datang Kembali ' . $collection->data->name, 
                    'response' => $check->getStatusCode(),
                    'session' => Session::get('token'),
                    'route' => route('web.home'),
                ]);
            }
            if($check->getStatusCode() == 400 || $check->getStatusCode() == 401){
                return response()->json([
                    'alert' => 'error',
                    'message' => 'Unauthorized Wrong credentials email / password',
                    'response' => $check->getStatusCode(),
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
    public function do_register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required|min:9|max:15',
            'password' => 'required|min:8|max:12',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            if ($errors->has('name')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('name'),
                ]);
            } elseif ($errors->has('email')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('email'),
                ]);
            } elseif ($errors->has('phone')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('phone'),
                ]);
            } elseif ($errors->has('password')) {
                return response()->json([
                    'alert' => 'error',
                    'message' => $errors->first('password'),
                ]);
            }
        }
        try {
            $req = Http::post("127.0.0.1:8002/api/auth/register",[
                'name'=> $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'phone' => $request->phone,
                'role' => 'user',
            ]);
            if($req->getStatusCode() == 500 || $req->getStatusCode() == 404 || $req->getStatusCode() == 403) {
                    return response()->json([
                        'alert' => 'error',
                        'message' => 'request failed',
                        'response' => $req->getStatusCode(),
                        'route' => route('web.auth.index'),
                    ]);
            }
            return response()->json([
                'alert' => 'success',
                'message' => 'Customer ' . $request->name . ' Sukses Terdaftar',
                'response' => $req->getStatusCode(),
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

    public function do_logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect()->route('web.home');
    }
}
