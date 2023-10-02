<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RouteController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }
    public function index()
    {
        $response = $this->client->get(env('API_URL') . '/routes', [
            'headers' => [
                'Authorization' => 'Bearer ' . Cache::get('auth_token')
            ],
            'query' => [
                'user_id' => Cache::get('user')['uuid']
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

        return view('pages.route', compact('meta', 'datas', 'categories', 'villages'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'long_route' => 'required',
            'height_start' => 'required',
            'height_end' => 'required',
            'level' => 'required',
            'village_id' => 'required',
            'image.*' => 'required|image|mimes:jpeg,png,jpg|max:5120', // Notice the use of image.* to validate multiple images.
        ]);

        $images = $request->file('image');
        $imageData = [];

        foreach ($images as $image) {
            $image_path = $image->getPathname();
            $filename = $image->getClientOriginalName();

            // Add each image data to the array.
            $imageData[] = [
                'name' => 'image[]', // Use square brackets for multiple images.
                'contents' => fopen($image_path, 'r'),
                'filename' => $filename,
            ];
        }

        $response = $this->client->post(env('API_URL') . '/routes', [
            'headers' => [
                'Authorization' => 'Bearer ' . Cache::get('auth_token')
            ],
            'multipart' => array_merge(
                [
                    [
                        'name' => 'name',
                        'contents' => $request->name,
                    ],
                    [
                        'name' => 'category_id',
                        'contents' => $request->category_id,
                    ],
                    [
                        'name' => 'description',
                        'contents' => $request->description,
                    ],
                    [
                        'name' => 'long_route',
                        'contents' => $request->long_route,
                    ],
                    [
                        'name' => 'height_start',
                        'contents' => $request->height_start,
                    ],
                    [
                        'name' => 'height_end',
                        'contents' => $request->height_end,
                    ],
                    [
                        'name' => 'level',
                        'contents' => $request->level,
                    ],
                    [
                        'name' => 'village_id',
                        'contents' => $request->village_id,
                    ]
                ],
                $imageData // Add the image data array here.
            ),
        ]);

        $body = json_decode($response->getBody()->getContents(), true);

        if (!$body['status']) {
            abort(500, $body['message']);
        }

        return redirect()->back()->with('success', 'Berhasil menambahkan rute baru');
    }

    public function destroy($id)
    {
        $response = $this->client->delete(env('API_URL') . '/routes/' . $id, [
            'headers' => [
                'Authorization' => 'Bearer ' . Cache::get('auth_token')
            ]
        ]);

        $body = json_decode($response->getBody()->getContents(), true);

        if (!$body['status']) {
            abort(500, $body['message']);
        }

        return redirect()->back()->with('success', 'Berhasil menghapus rute');
    }

    public function listRoutes($id)
    {
        // return view('pages.add-route-list');
        $response = $this->client->get(env('API_URL') . '/list/routes/' . $id, [
            'headers' => [
                'Authorization' => 'Bearer ' . Cache::get('auth_token')
            ]
        ]);
        $body = json_decode($response->getBody()->getContents(), true);

        if (!$body['status']) {
            abort(500, $body['message']);
        }

        $datas = $body['data']['routes'];

        return view('pages.route-list', compact('datas', 'id'));
    }

    public function storeListRoutes(Request $request)
    {
        $validate = $request->validate([
            'route_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'image' => 'required',
        ]);

        $image = $request->file('image');
        $image_path = $image->getPathname();
        $filename = $image->getClientOriginalName();

        $response = $this->client->post(env('API_URL') . '/list/routes', [
            'headers' => [
                'Authorization' => 'Bearer ' . Cache::get('auth_token')
            ],
            'multipart' => [
                [
                    'name' => 'route_id',
                    'contents' => $request->route_id,
                ],
                [
                    'name' => 'latitude',
                    'contents' => $request->latitude,
                ],
                [
                    'name' => 'longitude',
                    'contents' => $request->longitude,
                ],
                [
                    'name' => 'image',
                    'contents' => fopen($image_path, 'r'),
                    'filename' => $filename,
                ],
            ],
        ]);

        $body = json_decode($response->getBody()->getContents(), true);

        if (!$body['status']) {
            abort(500, $body['message']);
        }

        return redirect()->back()->with('success', 'Berhasil menambahkan rute baru');
    }

    public function destroyListRoutes($id)
    {
        $response = $this->client->delete(env('API_URL') . '/list/routes/' . $id, [
            'headers' => [
                'Authorization' => 'Bearer ' . Cache::get('auth_token')
            ]
        ]);

        $body = json_decode($response->getBody()->getContents(), true);

        if (!$body['status']) {
            abort(500, $body['message']);
        }

        return redirect()->back()->with('success', 'Berhasil menghapus rute');
    }

    public function map($id)
    {
        // return view('pages.add-route-list');
        $response = $this->client->get(env('API_URL') . '/list/routes/' . $id, [
            'headers' => [
                'Authorization' => 'Bearer ' . Cache::get('auth_token')
            ]
        ]);
        $body = json_decode($response->getBody()->getContents(), true);

        if (!$body['status']) {
            abort(500, $body['message']);
        }

        $datas = $body['data']['routes'];

        return view('pages.view-route-list', compact('datas'));
    }
}
