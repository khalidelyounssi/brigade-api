<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Tag(
    name: 'Recommendations',
    description: 'AI recommendations endpoints'
)]
class RecommendationSwagger
{
    #[OA\Post(
        path: '/api/recommendations/analyze/{plate_id}',
        summary: 'Launch recommendation analysis',
        security: [['bearerAuth' => []]],
        tags: ['Recommendations'],
        parameters: [
            new OA\Parameter(name: 'plate_id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 202, description: 'Analysis launched'),
            new OA\Response(response: 404, description: 'Plate not found'),
        ]
    )]
    public function analyze()
    {
    }

    #[OA\Get(
        path: '/api/recommendations',
        summary: 'List recommendation history',
        security: [['bearerAuth' => []]],
        tags: ['Recommendations'],
        responses: [
            new OA\Response(response: 200, description: 'Recommendations list'),
            new OA\Response(response: 401, description: 'Unauthorized'),
        ]
    )]
    public function index()
    {
    }

    #[OA\Get(
        path: '/api/recommendations/{plate_id}',
        summary: 'Get recommendation result by plate',
        security: [['bearerAuth' => []]],
        tags: ['Recommendations'],
        parameters: [
            new OA\Parameter(name: 'plate_id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Recommendation details'),
            new OA\Response(response: 404, description: 'Recommendation not found'),
        ]
    )]
    public function show()
    {
    }
}