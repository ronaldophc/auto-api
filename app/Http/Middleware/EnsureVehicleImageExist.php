<?php

namespace App\Http\Middleware;

use App\Models\VehicleImage;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureVehicleImageExist
{

    public function handle(Request $request, Closure $next): Response
    {
        $image = VehicleImage::find($request->route('image'));
        if (!$image) {
            return response()->json([
                'status' => false,
                'message' => 'Image not found'
            ], 404);
        }

        return $next($request);
    }
}
