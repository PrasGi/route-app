<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }
    public function index(Request $request)
    {
        $response = $this->client->get(env('API_URL') . '/routes', [
            'headers' => [
                'Authorization' => 'Bearer ' . Cache::get('auth_token')
            ],
            'query' => [
                'level' => $request->level ?? '',
                'category_id' => $request->category_id ?? '',
                'village_id' => $request->village_id ?? '',
            ]
        ]);

        $body = json_decode($response->getBody()->getContents(), true);

        if (!$body['status']) {
            abort(500, $body['message']);
        }

        $responseCategory = $this->client->get(env('API_URL') . '/categories');
        $bodyCategory = json_decode($responseCategory->getBody()->getContents(), true);

        if (!$bodyCategory['status']) {
            abort(500, $bodyCategory['message']);
        }

        $responseVillages = $this->client->get(env('API_URL') . '/villages');
        $bodyVillages = json_decode($responseVillages->getBody()->getContents(), true);

        if (!$bodyVillages['status']) {
            abort(500, $bodyVillages['message']);
        }

        $datas = $body['data']['routes']['data'];
        $meta = $body['data']['routes']['meta'];
        $categories = $bodyCategory['data']['categories'];
        $villages = $bodyVillages['data']['data'];

        return view('welcome', compact('meta', 'datas', 'categories', 'villages'));
    }
}
