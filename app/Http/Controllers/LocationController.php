<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function update(Request $request, Location $location)
    {
        try {
            $validated = $request->validate([
                'facility_name' => 'required|string|max:255',
                'address' => 'required|string',
                'notes' => 'nullable|string'
            ]);

            $location->update($validated);

            return response()->json([
                'success' => true,
                'location' => $location->fresh()
            ]);
        } catch (\Exception $e) {
            \Log::error('Location update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error updating location: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'facility_name' => 'required',
                'address' => 'required',
                'notes' => 'nullable'
            ]);

            $location = Location::create([
                'facility_name' => $request->facility_name,
                'address' => $request->address,
                'notes' => $request->notes
            ]);

            return response()->json([
                'success' => true,
                'location' => $location
            ]);
        } catch (\Exception $e) {
            \Log::error('Location store error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function search(Request $request)
    {
        $query = $request->get('query');

        $locations = Location::where('facility_name', 'LIKE', "%{$query}%")
            ->orWhere('address', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get();

        return response()->json($locations);
    }
}