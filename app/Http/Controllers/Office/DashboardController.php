<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
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
    
    public function index()
    {
        $inspiring = Artisan::command('inspire', function () {
            $this->comment(Inspiring::quote());
        })->describe('Display an inspiring quote');
        return view('page.office.dashboard.main', compact('inspiring'));
    }
}
