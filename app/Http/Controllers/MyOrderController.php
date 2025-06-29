<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\BookingTransaction;
use App\Services\BookingTransactionService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class MyOrderController extends Controller
{
    private BookingTransactionService $bookingTransactionService;

    public function __construct(BookingTransactionService $bookingTransactionService) {
        $this->bookingTransactionService = $bookingTransactionService;
    }

    public function index()
    {
        $orders = $this->bookingTransactionService->getAllForUser(auth()->id);
        return response()->json(TransactionResource::collection($orders));
    }

    public function show(int $id)
    {
        try {
            $order = $this->bookingTransactionService->getById($id, auth()->id);
            return response()->json(new TransactionResource($order));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Order not found'
            ], 404);
        }
    }

    public function store(BookingTransactionRequest $request)
    {
        $transaction = $this->bookingTransactionService->create($request->validated());
        return response()->json(new TransactionResource($transaction), 201);
    }
}
