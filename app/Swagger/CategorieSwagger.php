<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Tag(
    name: 'Categories',
    description: 'Categories endpoints'
)]
class CategorieSwagger
{
    #[OA\Get(
        path: '/api/categories',
        summary: 'List categories',
        security: [['bearerAuth' => []]],
        tags: ['Categories'],
        responses: [
            new OA\Response(response: 200, description: 'Categories list'),
            new OA\Response(response: 401, description: 'Unauthorized'),
        ]
    )]
    public function index()
    {
    }

    #[OA\Post(
        path: '/api/categories',
        summary: 'Create category',
        security: [['bearerAuth' => []]],
        tags: ['Categories'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Desserts'),
                    new OA\Property(property: 'description', type: 'string', example: 'Sweet dishes'),
                    new OA\Property(property: 'color', type: 'string', example: '#FF5733'),
                    new OA\Property(property: 'is_active', type: 'boolean', example: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Category created'),
            new OA\Response(response: 403, description: 'Forbidden'),
            new OA\Response(response: 422, description: 'Validation error'),
        ]
    )]
    public function store()
    {
    }

    #[OA\Get(
        path: '/api/categories/{id}',
        summary: 'Show category',
        security: [['bearerAuth' => []]],
        tags: ['Categories'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Category details'),
            new OA\Response(response: 404, description: 'Not found'),
        ]
    )]
    public function show()
    {
    }

    #[OA\Put(
        path: '/api/categories/{id}',
        summary: 'Update category',
        security: [['bearerAuth' => []]],
        tags: ['Categories'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Desserts Updated'),
                    new OA\Property(property: 'description', type: 'string', example: 'Updated description'),
                    new OA\Property(property: 'color', type: 'string', example: '#33AAFF'),
                    new OA\Property(property: 'is_active', type: 'boolean', example: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Category updated'),
            new OA\Response(response: 403, description: 'Forbidden'),
            new OA\Response(response: 404, description: 'Not found'),
        ]
    )]
    public function update()
    {
    }

    #[OA\Delete(
        path: '/api/categories/{id}',
        summary: 'Delete category',
        security: [['bearerAuth' => []]],
        tags: ['Categories'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Category deleted'),
            new OA\Response(response: 403, description: 'Forbidden'),
            new OA\Response(response: 404, description: 'Not found'),
            new OA\Response(response: 422, description: 'Category has active plats'),
        ]
    )]
    public function destroy()
    {
    }

    #[OA\Get(
        path: '/api/categories/{id}/plates',
        summary: 'Get plates by category',
        security: [['bearerAuth' => []]],
        tags: ['Categories'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Plates by category'),
            new OA\Response(response: 404, description: 'Category not found'),
        ]
    )]
    public function plates()
    {
    }
}