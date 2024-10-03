<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleImageRequest;
use App\Models\VehicleImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VehicleImageController extends Controller
{
    public function list($vehicleId): JsonResponse
    {
        $images = VehicleImage::where('vehicle_id', $vehicleId)->get();
        return response()->json([
            'status' => true,
            'data' => $images
        ], 200);
    }

    public function show(): JsonResponse
    {
        $image = VehicleImage::find(request()->route('image'));
        return response()->json([
            'status' => true,
            'data' => $image,
            'image_url' => asset('storage/' . $image->image_url)
        ], 200);
    }

    public function store(VehicleImageRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $data = $request->all();

            $image = VehicleImage::create($data);
            DB::commit();
            return response()->json([
                'status' => true,
                'data' => $image,
                'message' => 'Image created',
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e
            ], 400);
        }


    }

    public function destroy($id): JsonResponse
    {
        $image = VehicleImage::findOrFail($id);

        Storage::disk('public')->delete($image->image_url);

        $image->delete();

        return response()->json(null, 204);
    }


}
