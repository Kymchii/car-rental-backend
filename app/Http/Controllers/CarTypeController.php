<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CarType;
use Illuminate\Http\Request;

class CarTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = CarType::with('carBrand');

        if ($request->brand_id) {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        $carTypes = $query->get();
        return response()->json([
            'success' => true,
            'data' => $carTypes,
        ], 200);
    }
}