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

    public function show($vehicleId): JsonResponse
    {
        try {
            $image = VehicleImage::query()
                ->where('vehicle_id', $vehicleId)
                ->where('is_cover', true)
                ->first();

            if (!$image) {
                throw new \Exception('No cover image found for this vehicle.');
            }

            return response()->json([
                'status' => true,
                'data' => $image,
                'image_url' => $image->image_url
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 404);
        }

    }

    public function store(VehicleImageRequest $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $data = $request->all();
            $image = $request->file('image');

            if (!$image) {
                throw new \Exception('No image file found in the request.');
            }

            $imageName = time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('images')->putFileAs('', $image, $imageName);
            $path = 'images/' . $imageName;

            $vehicleId = $data['vehicle_id'];
            $is_cover = filter_var($data['is_cover'], FILTER_VALIDATE_BOOLEAN);

            $image = VehicleImage::query()->create([
                'vehicle_id' => $vehicleId,
                'image_url' => $path,
                'is_cover' => $is_cover,
            ]);

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
                'error' => 'error na controller',
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
