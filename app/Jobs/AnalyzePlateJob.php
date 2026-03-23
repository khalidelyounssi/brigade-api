<?php

namespace App\Jobs;

use App\Models\Recommendation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AnalyzePlateJob implements ShouldQueue
{
    use Dispatchable, Queueable;

    public $plate;
    public $user;

    public function __construct($plate, $user)
    {
        $this->plate = $plate;
        $this->user = $user;
    }

    public function handle()
    {
        $score = 100;
        $warnings = [];

        foreach ($this->plate->ingredients as $ingredient) {
            foreach ($ingredient->tags as $tag) {

                if (in_array($tag, $this->user->dietary_tags ?? [])) {
                    $score -= 30;
                    $warnings[] = $tag;
                }
            }
        }

        if ($score < 0) {
            $score = 0;
        }

        $label = $score >= 80
            ? 'Highly Recommended'
            : ($score >= 50 ? 'Recommended' : 'Not Recommended');

        Recommendation::updateOrCreate(
            [
                'user_id' => $this->user->id,
                'plate_id' => $this->plate->id,
            ],
            [
                'score' => $score,
                'label' => $label,
                'warning_message' => implode(', ', $warnings),
                'status' => 'ready'
            ]
        );
    }
}