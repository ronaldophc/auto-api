<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequest;
use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    public function list(): JsonResponse
    {
        $stores = Store::orderBy('id', 'asc')->get();
        return response()->json([
            'status' => true,
            'data' => $stores
        ], 200);
    }

    public function show(Store $store): JsonResponse
    {
        return response()->json([
            'status' => true,
            'data' => $store
        ], 200);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $data = $request->all();
            $store = Store::create($data);

            DB::commit();
            return response()->json([
                'status' => true,
                'data' => $store,
                'message' => 'Store created'
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Store not created'
            ], 400);
        }

    }

    public function update(StoreRequest $request, Store $store): JsonResponse
    {
        DB::beginTransaction();

        try {
            $data = $request->all();
            $store->update($data);
            DB::commit();
            return response()->json([
                'status' => true,
                'data' => $store,
                'message' => 'Store updated',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e
            ], 400);
        }
    }

}
