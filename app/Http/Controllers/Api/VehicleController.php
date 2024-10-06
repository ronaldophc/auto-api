<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleRequest;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehicleController extends Controller
{
    public function list(Request $request): JsonResponse
    {
        $query = Vehicle::query();

        // Aplicar filtros
        if ($request->has('year_min') && $request->has('year_max')) {
            $query->whereBetween('model_year', [$request->year_min, $request->year_max]);
        }

        if ($request->has('price_min') && $request->has('price_max')) {
            $query->whereBetween('price', [$request->price_min, $request->price_max]);
        }

        if (isset($request->km_min) && isset($request->km_max)) {
            $kmMin = intval($request->km_min);
            $kmMax = intval($request->km_max);
            $query->whereBetween('current_km', [$kmMin, $kmMax]);
        }

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Ordenação
        if ($request->has('order_by')) {
            $query->orderBy('price', $request->order_by);
        }

        // Paginação
        if ($request->has('per_page')) {
            $vehicles = $query->paginate($request->per_page);
        } else {
            $vehicles = $query->get();
        }

        return response()->json([
            'status' => true,
            'data' => $vehicles,
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

    public function destroy(Vehicle $vehicle): JsonResponse
    {
        try {
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

    public function search(Request $request): JsonResponse
    {
        $query = Vehicle::query();

        // Captura o valor da pesquisa
        $query = $request['query'];

        // Realiza a pesquisa no modelo
        $results = Car::where('manufacturer', 'LIKE', "%{$query}%")
            ->orWhere('model', 'LIKE', "%{$query}%");

        if ($request->has('per_page')) {
            $vehicles = $results->paginate($request->per_page);
        } else {
            $vehicles = $results->get();
        }

        return response()->json([
            'status' => true,
            'data' => $vehicles
        ], 200);
    }
}
