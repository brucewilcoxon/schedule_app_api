<?php

namespace App\Http\Controllers;

use App\Models\Gas;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class GasController extends Controller
{
    /**
     * Display a listing of the resource with filters and summary.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Gas::query();

        // Apply filters
        if ($request->filled('start_date')) {
            $query->where('date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->where('date', '<=', $request->end_date);
        }
        if ($request->filled('gas_type') && $request->gas_type !== 'all') {
            $query->where('gas_type', $request->gas_type);
        }
        if ($request->filled('prefecture') && $request->prefecture !== 'all') {
            $query->where('prefecture', $request->prefecture);
        }
        if ($request->filled('process') && $request->process !== 'all') {
            $query->where('process', $request->process);
        }

        $gasData = $query->orderBy('date', 'desc')->get();

        // Calculate summary
        $summary = [
            'recovery' => $gasData->where('process', 'recovery')->sum('quantity'),
            'filling' => $gasData->where('process', 'filling')->sum('quantity'),
            'refilling' => $gasData->where('process', 'refilling')->sum('quantity'),
            'recovery_refilling' => $gasData->where('process', 'recovery_refilling')->sum('quantity'),
            'recovery_disposal' => $gasData->where('process', 'recovery_disposal')->sum('quantity'),
            'recovery_impossible' => $gasData->where('process', 'recovery_impossible')->sum('quantity'),
        ];
        $summary['total'] = $summary['recovery'] + $summary['filling'] + $summary['refilling'] + 
                           $summary['recovery_refilling'] + $summary['recovery_disposal'] + $summary['recovery_impossible'];

        // Group by date
        $dailyData = $gasData->groupBy(function ($item) {
            return Carbon::parse($item->date)->format('Y-m-d');
        })->map(function ($items, $date) {
            return [
                'date' => $date,
                'total' => $items->sum('quantity'),
                'items' => $items->values()
            ];
        })->values();

        return response()->json([
            'data' => $gasData,
            'summary' => $summary,
            'daily_data' => $dailyData
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'gas_type' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'date' => 'required|date',
            'prefecture' => 'required|string|max:255',
            'process' => 'required|in:recovery,filling,refilling,recovery_refilling,recovery_disposal,recovery_impossible',
        ]);

        $gas = Gas::create($validated);

        return response()->json($gas, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Gas $gas): JsonResponse
    {
        return response()->json($gas);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gas $gas): JsonResponse
    {
        $validated = $request->validate([
            'gas_type' => 'sometimes|required|string|max:255',
            'quantity' => 'sometimes|required|numeric|min:0',
            'date' => 'sometimes|required|date',
            'prefecture' => 'sometimes|required|string|max:255',
            'process' => 'sometimes|required|in:recovery,filling,refilling,recovery_refilling,recovery_disposal,recovery_impossible',
        ]);

        $gas->update($validated);

        return response()->json($gas);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gas $gas): JsonResponse
    {
        $gas->delete();

        return response()->json(['message' => 'Gas record deleted successfully']);
    }

    /**
     * Get available gas types for filtering
     */
    public function getGasTypes(): JsonResponse
    {
        $gasTypes = Gas::distinct()->pluck('gas_type')->filter()->values();
        return response()->json($gasTypes);
    }

    /**
     * Get available prefectures for filtering
     */
    public function getPrefectures(): JsonResponse
    {
        $prefectures = Gas::distinct()->pluck('prefecture')->filter()->values();
        return response()->json($prefectures);
    }
}
