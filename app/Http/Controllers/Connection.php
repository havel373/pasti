<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Http\Request;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class Connection
{
    public function callable(){
        return view('errors.500');
    }

    public function produks()
    {

        try {
            $url = "127.0.0.1:8001/api/produks";
            // dd($check);
            $connect = new Client([
                'base_uri' => $url,
            ]);
            $response = $connect->request('GET');
            $response = json_decode($response->getBody());
            $response = $response->data;

            return $response;
        } catch (ConnectException $e) {

        } catch (Exception $e) {

        }
    }

    public function orders(){
        try {
            $url = "127.0.0.1:8003/api/orders";
            // dd($check);
            $connect = new Client([
                'base_uri' => $url,
            ]);
            $response = $connect->request('GET');
            $response = json_decode($response->getBody());
            $response = $response->data;
            return $response;
        } catch (ConnectException $e) {
            // dd($e);
        } catch (Exception $e) {
            // return $e;
            // dd($e);
        }
    }
    public function users(){
        try {
            $url = "127.0.0.1:8002/api/all";
            // dd($check);
            $connect = new Client([
                'base_uri' => $url,
            ]);
            $response = $connect->request('GET');
            $response = json_decode($response->getBody());
            $response = $response->data;
            return $response;
        } catch (ConnectException $e) {
            // dd($e);
        } catch (Exception $e) {
            // return $e;
            // dd($e);
        }
    }
    public function gallery(){
        try {
            $url = "127.0.0.1:8004/api/gallery";
            // dd($check);
            $connect = new Client([
                'base_uri' => $url,
            ]);
            $response = $connect->request('GET');
            $response = json_decode($response->getBody());
            $response = $response->data;
            return $response;
        } catch (ConnectException $e) {
            // dd($e);
        } catch (Exception $e) {
            // return $e;
            // dd($e);
        }
    }
}
    