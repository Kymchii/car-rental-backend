<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function index()
    {
        $client = Client::where('user_id', auth()->id())->with('user')->first();
        return response()->json([
            'success' => true,
            'data' => $client,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:13|unique:clients,phone',
            'address' => 'required|string|max:255',
        ], [
            'phone.required' => 'Filed wajib diisi',
            'phone.unique' => 'Nomor telepon sudah terdaftar',
            'address.required' => 'Filed wajib diisi'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $client = Client::create([
            'user_id' => auth()->id(),
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dilengkapi',
            'data' => $client,
        ], 201);
    }

    public function update(Request $request)
    {
        $client = Client::where('user_id', auth()->id())->first();

        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:13|unique:clients,phone,' . $client->id,
            'address' => 'required|string|max:255',
        ], [
            'phone.required' => 'Filed wajib diisi',
            'phone.unique' => 'Nomor telepon sudah terdaftar',
            'address.required' => 'Filed wajib diisi'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $client->update([
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diupdate',
            'data' => $client,
        ], 200);
    }
}
