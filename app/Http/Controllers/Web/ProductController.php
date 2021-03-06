<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Exception;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    public function show($id)
    {
        try {
            $arr = Http::get("127.0.0.1:8001/api/produks/{$id}");
            $arr = json_decode($arr);
            $product = $arr->data;
            $collection =  Http::get("127.0.0.1:8001/api/produks");
            $collection =  json_decode($collection,false);
            $collection = $collection->data;
            return view('page.web.product.show',compact('product','collection'));
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
}
