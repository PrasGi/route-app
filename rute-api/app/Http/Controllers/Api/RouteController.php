<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Route\CreateRequest;
use App\Http\Requests\Route\Detail\CreateRequest as DetailCreateRequest;
use App\Http\Requests\Route\UpdateRequest;
use App\Http\Resources\Detail\DetailCollection;
use App\Http\Resources\Detail\DetailResource;
use App\Http\Resources\Route\RouteCollection;
use App\Http\Resources\Route\RouteResource;
use App\Models\Detail;
use App\Models\Galery;
use App\Models\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RouteController extends Controller
{
    private $routeModel;
    private $galeryModel;
    private $detailModel;

    public function __construct()
    {
        $this->routeModel = new Route();
        $this->galeryModel = new Galery();
        $this->detailModel = new Detail();
    }

    public function index(Request $request)
    {
        $filter = [
            'name' => $request->name ?? null,
            'description' => $request->description ?? null,
            'height_start' => $request->height_start ?? null,
            'height_end' => $request->height_end ?? null,
        ];

        $routes = $this->routeModel::query();

        if ($filter['name']) {
            $routes->where('name', 'like', "%{$filter['name']}%");
        }

        if ($filter['description']) {
            $routes->where('description', 'like', "%{$filter['description']}%");
        }

        if ($filter['height_start']) {
            $routes->where('height_start', '>=', $filter['height_start']);
        }

        if ($filter['height_end']) {
            $routes->where('height_end', '<=', $filter['height_end']);
        }

        $datas = $routes->with('galeries')->orderBy('created_at', 'desc')->paginate($request->per_page ?? 25);

        return response()->json([
            'status' => true,
            'data' => [
                'routes' => new RouteCollection($datas),
            ]
        ]);
    }

    public function store(CreateRequest $createRequest)
    {
        if ($createRequest->validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $createRequest->validator->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $payload = $createRequest->only([
                'name',
                'description',
                'long_route',
                'height_start',
                'height_end',
            ]);

            $route = $this->routeModel->create($payload);

            if (!$route) {
                throw new \Exception('Failed to create route');
            }

            if ($createRequest->hasFile('image')) {
                foreach ($createRequest->file('image') as $image) {
                    $path = $image->store('images/galeries', 'public');

                    $this->galeryModel::create([
                        'route_id' => $route->id,
                        'image' => $path,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Route created successfully',
                'data' => [
                    'route' => new RouteResource($route),
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Internal server error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(UpdateRequest $updateRequest, Route $route)
    {
        if ($updateRequest->validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $updateRequest->validator->errors(),
            ], 422);
        }

        $payload = $updateRequest->only([
            'name',
            'description',
            'long_route',
            'height_start',
            'height_end',
        ]);

        if ($route->update($payload)) {
            return response()->json([
                'status' => true,
                'message' => 'Route updated successfully',
                'data' => [
                    'route' => new RouteResource($route),
                ]
            ]);
        }
    }

    public function show(Route $route)
    {
        return response()->json([
            'status' => true,
            'data' => [
                'route' => new RouteResource($route),
            ]
        ], 200);
    }

    public function destroy(Route $route)
    {
        if ($route->delete()) {
            return response()->json([
                'status' => true,
                'message' => 'Route deleted successfully',
            ]);
        }
    }

    public function listRoute(Route $route)
    {
        $routes = $this->detailModel->query()->where('route_id', $route->id)->get();

        return response()->json([
            'status' => true,
            'data' => [
                'routes' => new DetailCollection($routes)
            ]
        ]);
    }

    public function addRoute(DetailCreateRequest $detailCreateRequest)
    {
        if ($detailCreateRequest->validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $detailCreateRequest->validator->errors(),
            ], 422);
        }

        $payload = $detailCreateRequest->only([
            'route_id',
            'image',
            'latitude',
            'longitude',
        ]);

        if ($detailCreateRequest->hasFile('image')) {
            $payload['image'] = $detailCreateRequest->file('image')->store('images/details', 'public');
        }

        if ($detail = $this->detailModel->create($payload)) {
            return response()->json([
                'status' => true,
                'message' => 'Detail created successfully',
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => new DetailResource($detail),
        ], 500);
    }

    public function destroyRoute(Detail $detail)
    {
        if ($detail->delete()) {
            return response()->json([
                'status' => true,
                'message' => 'Detail deleted successfully',
            ]);
        }
    }
}
