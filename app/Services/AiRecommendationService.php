<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class AiRecommendationService
{
    public function analyze($plat, array $ingredientTags, array $restrictions): array
    {
        $prompt = $this->buildPrompt(
            $plat->toArray(),
            implode(', ', $ingredientTags),
            implode(', ', $restrictions)
        );

        $aiText = $this->callGrok($prompt);

        if (! $aiText) {
            throw new RuntimeException('AI service unavailable');
        }

        return $this->parseResponse($aiText);
    }

    private function buildPrompt(array $plate, string $ingredients, string $restrictions): string
    {
        return <<<PROMPT
Analyze the nutritional compatibility between this dish and the user's dietary restrictions.

DISH: {$plate['name']}
INGREDIENT TAGS: {$ingredients}
USER RESTRICTIONS: {$restrictions}

Tag mapping rules:
- "vegan" restriction conflicts with: contains_meat, contains_lactose
- "no_sugar" restriction conflicts with: contains_sugar
- "no_cholesterol" restriction conflicts with: contains_cholesterol
- "gluten_free" restriction conflicts with: contains_gluten
- "no_lactose" restriction conflicts with: contains_lactose

Calculate score: start at 100, subtract 25 for each conflict found.

Respond ONLY with this JSON (no markdown, no explanation):
{"score": <0-100>, "warning_message": "<in French if score < 50, else empty string>"}
PROMPT;
    }

    private function callGrok(string $prompt): ?string
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.groq.com/openai/v1/chat/completions', [
            'model' => env('GROQ_MODEL', 'llama3-70b-8192'),
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are a strict nutrition recommendation engine. Return only valid JSON.'
                ],
                [
                    'role' => 'user',
                    'content' => $prompt
                ]
            ],
            'temperature' => 0.2
        ]);

        if (! $response->successful()) {
            Log::error('Groq API error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        }

        return $response->json()['choices'][0]['message']['content'] ?? null;
    }

    private function parseResponse(string $text): array
    {
        $text = preg_replace('/```json|```/', '', $text);
        $text = trim($text);

        preg_match('/\{.*\}/s', $text, $matches);
        $data = json_decode($matches[0] ?? '{}', true);

        if (! isset($data['score'])) {
            Log::warning('AI response parsing failed', ['text' => $text]);

            return [
                'score' => 50,
                'label' => '🟡 Recommended with notes',
                'warning_message' => null,
            ];
        }

        $score = max(0, min(100, (int) $data['score']));
        $warning = $data['warning_message'] ?? '';

        $label = match (true) {
            $score >= 80 => '✅ Highly Recommended',
            $score >= 50 => '🟡 Recommended with notes',
            default => '⚠️ Not Recommended',
        };

        return [
            'score' => $score,
            'label' => $label,
            'warning_message' => $score < 50 ? $warning : null,
        ];
    }
}