<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Tag(
    name: 'Admin Stats',
    description: 'Admin statistics endpoint'
)]
class AdminStatsSwagger
{
    #[OA\Get(
        path: '/api/admin/stats',
        summary: 'Get global admin statistics',
        security: [['bearerAuth' => []]],
        tags: ['Admin Stats'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Admin statistics retrieved successfully'
            ),
            new OA\Response(
                response: 403,
                description: 'Forbidden'
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthorized'
            ),
        ]
    )]
    public function index()
    {
    }
}