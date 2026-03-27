<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Tag(
    name: 'Plats',
    description: 'Plats endpoints'
)]
class PlatSwagger
{
    #[OA\Get(
        path: '/api/plats',
        summary: 'List plats',
        security: [['bearerAuth' => []]],
        tags: ['Plats'],
        responses: [
            new OA\Response(response: 200, description: 'Plats list'),
            new OA\Response(response: 401, description: 'Unauthorized'),
        ]
    )]
    public function index()
    {
    }

    #[OA\Post(
        path: '/api/plats',
        summary: 'Create plat',
        security: [['bearerAuth' => []]],
        tags: ['Plats'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    required: ['name', 'price', 'category_id'],
                    properties: [
                        new OA\Property(property: 'name', type: 'string', example: 'Pizza'),
                        new OA\Property(property: 'description', type: 'string', example: 'Pizza fromage'),
                        new OA\Property(property: 'price', type: 'number', format: 'float', example: 50),
                        new OA\Property(property: 'category_id', type: 'integer', example: 1),
                        new OA\Property(property: 'is_available', type: 'boolean', example: true),
                        new OA\Property(
                            property: 'ingredient_ids',
                            type: 'array',
                            items: new OA\Items(type: 'integer'),
                            example: [1, 2]
                        ),
                        new OA\Property(
                            property: 'image',
                            type: 'string',
                            format: 'binary'
                        ),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Plat created'),
            new OA\Response(response: 403, description: 'Forbidden'),
            new OA\Response(response: 422, description: 'Validation error'),
        ]
    )]
    public function store()
    {
    }

    #[OA\Get(
        path: '/api/plats/{id}',
        summary: 'Show plat',
        security: [['bearerAuth' => []]],
        tags: ['Plats'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Plat details'),
            new OA\Response(response: 404, description: 'Plat not found'),
        ]
    )]
    public function show()
    {
    }

    #[OA\Post(
        path: '/api/categories/{categorie}/plats',
        summary: 'Create plat inside category',
        security: [['bearerAuth' => []]],
        tags: ['Plats'],
        parameters: [
            new OA\Parameter(name: 'categorie', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    required: ['name', 'price'],
                    properties: [
                        new OA\Property(property: 'name', type: 'string', example: 'Burger'),
                        new OA\Property(property: 'description', type: 'string', example: 'Burger maison'),
                        new OA\Property(property: 'price', type: 'number', format: 'float', example: 35),
                        new OA\Property(property: 'is_available', type: 'boolean', example: true),
                        new OA\Property(
                            property: 'ingredient_ids',
                            type: 'array',
                            items: new OA\Items(type: 'integer'),
                            example: [1, 2]
                        ),
                        new OA\Property(
                            property: 'image',
                            type: 'string',
                            format: 'binary'
                        ),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Plat added to category'),
            new OA\Response(response: 403, description: 'Forbidden'),
            new OA\Response(response: 422, description: 'Validation error'),
        ]
    )]
    public function storeByCategory()
    {
    }

    #[OA\Put(
        path: '/api/plats/{id}',
        summary: 'Update plat',
        security: [['bearerAuth' => []]],
        tags: ['Plats'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        requestBody: new OA\RequestBody(
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property: 'name', type: 'string', example: 'Pizza Updated'),
                        new OA\Property(property: 'description', type: 'string', example: 'Updated description'),
                        new OA\Property(property: 'price', type: 'number', format: 'float', example: 55),
                        new OA\Property(property: 'category_id', type: 'integer', example: 1),
                        new OA\Property(property: 'is_available', type: 'boolean', example: true),
                        new OA\Property(
                            property: 'ingredient_ids',
                            type: 'array',
                            items: new OA\Items(type: 'integer'),
                            example: [1, 3]
                        ),
                        new OA\Property(
                            property: 'image',
                            type: 'string',
                            format: 'binary'
                        ),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Plat updated'),
            new OA\Response(response: 403, description: 'Forbidden'),
            new OA\Response(response: 404, description: 'Plat not found'),
        ]
    )]
    public function update()
    {
    }

    #[OA\Delete(
        path: '/api/plats/{id}',
        summary: 'Delete plat',
        security: [['bearerAuth' => []]],
        tags: ['Plats'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Plat deleted'),
            new OA\Response(response: 403, description: 'Forbidden'),
            new OA\Response(response: 404, description: 'Plat not found'),
        ]
    )]
    public function destroy()
    {
    }
}