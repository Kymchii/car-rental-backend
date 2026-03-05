<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CarType;
use App\Models\Client;
use App\Models\Invoice;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_at' => 'required|date',
            'end_of' => 'required|date|after:start_at',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $carModel = CarType::find($request->car_type_id);
        $invoiceNumber = 'INV-' . date('Ymd') . '-' . rand(1000, 9999);
        $startDate = new DateTime($request->start_at);
        $endDate = new DateTime($request->end_of);
        $days = $endDate->diff($startDate)->days;
        $totalPrice = $carModel->price * $days;
        $paymentCode = strtoupper(bin2hex(random_bytes(8)));

        $invoice = Invoice::create([
            'user_id' => auth()->id(),
            'car_type_id' => $request->car_type_id,
            'invoice_number' => $invoiceNumber,
            'start_at' => $request->start_at,
            'end_of' => $request->end_of,
            'payment' => false,
            'payment_code' => $paymentCode,
            'total' => $totalPrice
        ]);

        $client = Client::where('user_id', auth()->id())->first();

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan lengkapi data anda!'
            ]);
        }

        $transaction = [
            'transaction_details' => [
                'order_id' => $invoice->invoice_number,
                'gross_amount' => (int)$totalPrice,
            ],
            'customer_details' => [
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
                'phone' => $client->phone,
            ],
            'item_details' => [
                [
                    'id' => $carModel->id,
                    'price' => (int)$carModel->price,
                    'quantity' => $days,
                    'name' => $carModel->name . ' (' . $days . ' days)',
                ]
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($transaction);

            return response()->json([
                'success' => true,
                'message' => 'Checkout berhasil',
                'data' => [
                    'invoice_id' => $invoice->id,
                    'invoice_number' => $invoiceNumber,
                    'payment_code' => $paymentCode,
                    'snap_token' => $snapToken,
                    'total' => $totalPrice,
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function notification(Request $request)
    {
        $payload = $request->all();

        if (empty($payload)) {
            return response()->json(['message' => 'No payload'], 400);
        }

        $transactionStatus = $payload['transaction_status'] ?? null;
        $orderId = $payload['order_id'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;

        $invoice = Invoice::where('invoice_number', $orderId)->first();

        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 200);
        }

        if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
            if ($fraudStatus == 'accept' || $fraudStatus == null) {
                $invoice->update([
                    'payment' => true,
                    'payment_method' => $payload['payment_type'] ?? null,
                    'va_number' => $payload['va_numbers'][0]['va_number'] ?? null,
                ]);
            }
        }

        return response()->json(['message' => 'OK'], 200);
    }

    public function update(Request $request, Invoice $invoice)
    {
        $invoice->update([
            'payment_method' => $request->payment_method,
            'va_number' => $request->va_number,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Invoice updated',
            'data' => $invoice,
        ], 200);
    }
}