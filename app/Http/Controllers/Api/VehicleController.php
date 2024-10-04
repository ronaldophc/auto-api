<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleRequest;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class VehicleController extends Controller
{
    public function list(): JsonResponse
    {
        $vehicles = Vehicle::orderBy('id', 'desc')->paginate(10);
        return response()->json([
            'status' => true,
            'data' => $vehicles
        ], 200);
    }

    public function show(Vehicle $vehicle): JsonResponse
    {
        return response()->json([
            'status' => true,
            'data' => $vehicle
        ], 200);
    }

    public function store(VehicleRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $data = $request->all();
            $vehicle = Vehicle::create($data);
            $id = $vehicle->id;
            DB::commit();
            return response()->json([
                'status' => true,
                'id' => $id,
                'message' => 'Vehicle created',
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e
            ], 400);
        }
    }

    public function update(VehicleRequest $request, Vehicle $vehicle): JsonResponse
    {
        DB::beginTransaction();

        try {
            $data = $request->all();
            $vehicle->update($data);
            DB::commit();
            return response()->json([
                'status' => true,
                'data' => $vehicle,
                'message' => 'Vehicle updated',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e
            ], 400);
        }
    }

    public function destroy(): JsonResponse
    {
        try {
            $vehicle = Vehicle::find(request()->route('vehicle'));
            $vehicle->delete();
            return response()->json([
                'status' => true,
                'message' => 'Vehicle deleted'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e
            ], 400);
        }
    }
}
