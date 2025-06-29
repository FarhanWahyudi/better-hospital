<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatusRequest;
use App\Http\Resources\TransactionResource;
use App\Services\BookingTransactionService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class BookingTransactionController extends Controller
{
    private BookingTransactionService $bookingTransactionService;

    public function __construct(BookingTransactionService $bookingTransactionService) {
        $this->bookingTransactionService = $bookingTransactionService;
    }

    public function index()
    {
        $transactions = $this->bookingTransactionService->getAll();
        return response()->json(TransactionResource::collection($transactions));
    }
    
    public function show(int $id)
    {
        try {
            $transaction = $this->bookingTransactionService->getByIdForManager($id);
            return response()->json(new TransactionResource($transaction));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Transaction not found'
            ], 404);
        }
    }

    public function updateStatus(StatusRequest $request, int $id)
    {
        $validated = $request->validated();

        try {
            $transaction = $this->bookingTransactionService->updateStatus($id, $validated['status']);
            return response()->json(new TransactionResource($transaction));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Transaction not found'
            ], 404);
        }
    }
}
