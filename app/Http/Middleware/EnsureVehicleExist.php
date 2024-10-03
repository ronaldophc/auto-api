<?php

namespace App\Http\Middleware;

use App\Models\Vehicle;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureVehicleExist
{

    public function handle(Request $request, Closure $next): Response
    {
        $vehicle = Vehicle::find($request->route('vehicle'));
        if (!$vehicle) {
            return response()->json([
                'status' => false,
                'message' => 'Vehicle not found'
            ], 404);
        }

        return $next($request);
    }
}
