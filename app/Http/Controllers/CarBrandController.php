<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CarBrand;
class CarBrandController extends Controller
{
    public function index()
    {
        $carBrands = CarBrand::orderBy('name', 'asc')->get();
        return response()->json([
            'success' => true,
            'data' => $carBrands,
        ], 200);
    }
}
