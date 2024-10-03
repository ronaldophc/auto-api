<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BusinessHourController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'store_id' => 'required|exists:stores,id',
            'hours' => 'required|array',
            'hours.*.*.opening_time' => 'required|date_format:H:i',
            'hours.*.*.closing_time' => 'required|date_format:H:i',
        ]);

        $businessHour = BusinessHour::create($validated);

        return response()->json($businessHour, 201);
    }

    public function update(Request $request, BusinessHour $businessHour)
    {
        $validated = $request->validate([
            'hours' => 'required|array',
            'hours.*.*.opening_time' => 'required|date_format:H:i',
            'hours.*.*.closing_time' => 'required|date_format:H:i',
        ]);

        $businessHour->update($validated);

        return response()->json($businessHour);
    }
}
