<?php

namespace App\Jobs;

use App\Models\Plat;
use App\Models\User;
use App\Models\Recommendation;
use App\Services\AiRecommendationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AnalyzePlateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $plateId;
    public int $userId;

    public function __construct(int $plateId, int $userId)
    {
        $this->plateId = $plateId;
        $this->userId = $userId;
    }

    public function handle(AiRecommendationService $aiRecommendationService): void
    {
        $plat = Plat::with('ingredients')->find($this->plateId);
        $user = User::find($this->userId);

        if (! $plat || ! $user) {
            Log::warning('AnalyzePlateJob: user or plate not found', [
                'plate_id' => $this->plateId,
                'user_id' => $this->userId,
            ]);
            return;
        }

        $ingredientTags = $plat->ingredients
            ->pluck('tags')
            ->flatten()
            ->filter()
            ->values()
            ->toArray();

        $restrictions = $user->dietary_tags ?? [];

        try {
            $parsed = $aiRecommendationService->analyze($plat, $ingredientTags, $restrictions);

            Recommendation::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'plate_id' => $plat->id,
                ],
                [
                    'score' => $parsed['score'],
                    'label' => $parsed['label'],
                    'warning_message' => $parsed['warning_message'],
                    'status' => 'ready',
                ]
            );
        } catch (\Throwable $e) {
            Log::error('AnalyzePlateJob failed', [
                'message' => $e->getMessage(),
                'plate_id' => $this->plateId,
                'user_id' => $this->userId,
            ]);

            Recommendation::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'plate_id' => $plat->id,
                ],
                [
                    'score' => 0,
                    'label' => 'Error',
                    'warning_message' => 'Erreur lors de l’analyse IA',
                    'status' => 'failed',
                ]
            );
        }
    }
}