<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::where('user_id', auth()->id())->with('user', 'carType.carBrand')->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $invoices,
        ], 200);
    }
}