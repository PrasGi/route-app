<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Galery\CreateRequest;
use App\Http\Resources\Galery\GaleryCollection;
use App\Http\Resources\Galery\GaleryResource;
use App\Models\Galery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GaleryController extends Controller
{
    private $galeryModel;

    public function __construct()
    {
        $this->galeryModel = new Galery();
    }

    public function index(Request $request)
    {
        $galeries = $request->route_id ? $this->galeryModel->query()->where('route_id', $request->route_id)->paginate($request->per_page ?? 25) : $this->galeryModel->query()->paginate($request->per_page ?? 25);

        return response()->json([
            'status' => true,
            'data' => [
                'galeries' => new GaleryCollection($galeries),
            ]
        ], 200);
    }

    public function store(CreateRequest $createRequest)
    {
        if ($createRequest->validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $createRequest->validator->errors()->first(),
            ], 400);
        }

        try {
            DB::beginTransaction();

            foreach ($createRequest->file('image') as $image) {
                $galery = new Galery();
                $galery->route_id = $createRequest->route_id;
                $galery->image = $image->store('images/galeries', 'public');
                $galery->save();
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil menambahkan gambar',
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function show(Galery $galery)
    {
        return response()->json([
            'status' => true,
            'data' => [
                'galery' => new GaleryResource($galery),
            ]
        ], 200);
    }

    public function destroy(Galery $galery)
    {
        if ($galery->delete()) {
            return response()->json([
                'status' => true,
                'message' => 'Berhasil menghapus gambar',
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'Gagal menghapus gambar',
        ], 500);
    }
}
