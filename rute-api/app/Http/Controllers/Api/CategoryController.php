<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new Category();
    }

    public function index()
    {
        return response()->json([
            'status' => true,
            'data' => [
                'categories' => $this->categoryModel::all()
            ]
        ]);
    }
}
