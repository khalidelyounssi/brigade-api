<?php

namespace App\Http\Controllers;

use App\Jobs\AnalyzePlateJob;
use App\Models\Plat;
use App\Models\Recommendation;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    public function analyze($plate_id)
    {
        $plat = Plat::findOrFail($plate_id);
        $user = auth()->user();

        Recommendation::updateOrCreate(
            [
                'user_id' => $user->id,
                'plate_id' => $plat->id,
            ], 
            [
                'score' => 0,
                'label' => 'Processing',
                'warning_message' => null,
                'status' => 'processing',
            ]
        );

        AnalyzePlateJob::dispatch($plat->id, $user->id);

        return response()->json([
            'message' => 'Analyse lancée avec succès',
            'status' => 'processing',
        ], 202);
    }

    public function index()
    {
        $recommendations = Recommendation::with('plat')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return response()->json($recommendations, 200);
    }

    public function show($plate_id)
    {
        $recommendation = Recommendation::with('plat')
            ->where('user_id', auth()->id())
            ->where('plate_id', $plate_id)
            ->latest()
            ->first();

        if (! $recommendation) {
            return response()->json([
                'message' => 'Aucune recommandation trouvée',
            ], 404);
        }

        return response()->json([
            'plate_id' => $recommendation->plate_id,
            'score' => $recommendation->score,
            'label' => $recommendation->label,
            'warning_message' => $recommendation->warning_message,
            'status' => $recommendation->status,
        ], 200);
    }
}