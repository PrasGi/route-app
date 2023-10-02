<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function indexProvince()
    {
        return response()->json([
            'status' => 'success',
            'data' => Province::all()
        ]);
    }

    public function indexRegienceId($id)
    {
        return response()->json([
            'status' => 'success',
            'data' => Regency::where('province_id', $id)->get()
        ]);
    }

    public function indexDistrictId($id)
    {
        return response()->json([
            'status' => 'success',
            'data' => District::where('regency_id', $id)->get()
        ]);
    }

    public function indexVillageId($id)
    {
        return response()->json([
            'status' => 'success',
            'data' => Village::where('district_id', $id)->get()
        ]);
    }

    public function indexVillage()
    {
        return response()->json([
            'status' => 'success',
            'data' => Village::paginate(25)
        ]);
    }
}
