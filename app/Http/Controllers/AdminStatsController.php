<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Ingredient;
use App\Models\Plat;
use App\Models\Recommendation;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class AdminStatsController extends Controller
{
    public function index(): JsonResponse
    {
        $user = auth()->user();

        if (! $user || ! $user->isAdmin()) {
            return response()->json([
                'message' => 'Accès interdit'
            ], 403);
        }

        $totalPlats = Plat::count();
        $totalCategories = Categorie::count();
        $totalIngredients = Ingredient::count();
        $totalRecommendations = Recommendation::count();

        $mostRecommendedPlate = Recommendation::select(
                'plate_id',
                DB::raw('AVG(score) as average_score')
            )
            ->groupBy('plate_id')
            ->orderByDesc('average_score')
            ->with('plat')
            ->first();

        $leastRecommendedPlate = Recommendation::select(
                'plate_id',
                DB::raw('AVG(score) as average_score')
            )
            ->groupBy('plate_id')
            ->orderBy('average_score')
            ->with('plat')
            ->first();

        $categoryWithMostPlats = Categorie::withCount('plats')
            ->orderByDesc('plats_count')
            ->first();

        return response()->json([
            'total_plats' => $totalPlats,
            'total_categories' => $totalCategories,
            'total_ingredients' => $totalIngredients,
            'total_recommendations' => $totalRecommendations,

            'most_recommended_plate' => $mostRecommendedPlate ? [
                'plate_id' => $mostRecommendedPlate->plate_id,
                'plate_name' => optional($mostRecommendedPlate->plat)->name,
                'average_score' => round((float) $mostRecommendedPlate->average_score, 2),
            ] : null,

            'least_recommended_plate' => $leastRecommendedPlate ? [
                'plate_id' => $leastRecommendedPlate->plate_id,
                'plate_name' => optional($leastRecommendedPlate->plat)->name,
                'average_score' => round((float) $leastRecommendedPlate->average_score, 2),
            ] : null,

            'category_with_most_plats' => $categoryWithMostPlats ? [
                'category_id' => $categoryWithMostPlats->id,
                'category_name' => $categoryWithMostPlats->name,
                'plats_count' => $categoryWithMostPlats->plats_count,
            ] : null,
        ], 200);
    }
}