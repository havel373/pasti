<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Connection;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Http\Request;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;

class WebController extends Controller
{
    public function index()
    {
        $connection = new Connection;
        $arr = $connection->produks();
        $inspiring = Inspiring::quote();
        $collection = Collection::make($arr);
        return view('page.web.home.main',compact('inspiring','collection'));
    }
    public function about()
    {
        $connection = new Connection;
        $arr = $connection->gallery();
        $collection = Collection::make($arr);
        return view('page.web.home.about', compact('collection'));
    }
}
