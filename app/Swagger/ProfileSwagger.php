<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Tag(
    name: 'Profile',
    description: 'Dietary profile endpoints'
)]
class ProfileSwagger
{
    #[OA\Get(
        path: '/api/profile',
        summary: 'Get dietary profile',
        security: [['bearerAuth' => []]],
        tags: ['Profile'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Profile retrieved successfully'
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthorized'
            ),
        ]
    )]
    public function show()
    {
    }

    #[OA\Put(
        path: '/api/profile',
        summary: 'Update dietary profile',
        security: [['bearerAuth' => []]],
        tags: ['Profile'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['dietary_tags'],
                properties: [
                    new OA\Property(
                        property: 'dietary_tags',
                        type: 'array',
                        items: new OA\Items(type: 'string'),
                        example: ['no_sugar', 'no_lactose']
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Profile updated successfully'
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error'
            ),
        ]
    )]
    public function update()
    {
    }
}