<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::orderBy('facility_name')->get();
        return response()->json($locations);
    }

    public function show(Location $location)
    {
        return response()->json([
            'success' => true,
            'location' => $location
        ])->header('Content-Type', 'application/json');
    }

    public function search(Request $request)
    {
        $query = $request->get('query');

        $locations = Location::where('facility_name', 'LIKE', "%{$query}%")
            ->orWhere('address', 'LIKE', "%{$query}%")
            ->orderBy('facility_name')
            ->limit(10)
            ->get();

        return response()->json($locations);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'facility_name' => 'required|string|max:255',
                'address' => 'required|string',
                'notes' => 'nullable|string'
            ]);

            $location = Location::create($validated);

            return response()->json([
                'success' => true,
                'location' => $location
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating location: ' . $e->getMessage()
            ], 422);
        }
    }

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
            return response()->json([
                'success' => false,
                'message' => 'Error updating location: ' . $e->getMessage()
            ], 422);
        }
    }

    public function destroy(Location $location)
    {
        try {
            // Verificăm dacă locația este folosită în loads
            $isUsed = \App\Models\Load::where('shipper_name', $location->facility_name)
                ->orWhere('receiver_name', $location->facility_name)
                ->exists();

            if ($isUsed) {
                throw new \Exception('This location is being used in one or more loads and cannot be deleted.');
            }

            $location->delete();

            return response()->json([
                'success' => true,
                'message' => 'Location deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}