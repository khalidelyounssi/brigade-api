<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Tag(
    name: 'Ingredients',
    description: 'Ingredients endpoints'
)]
class IngredientSwagger
{
    #[OA\Get(
        path: '/api/ingredients',
        summary: 'List ingredients',
        security: [['bearerAuth' => []]],
        tags: ['Ingredients'],
        responses: [
            new OA\Response(response: 200, description: 'Ingredients list'),
            new OA\Response(response: 403, description: 'Forbidden'),
        ]
    )]
    public function index()
    {
    }

    #[OA\Post(
        path: '/api/ingredients',
        summary: 'Create ingredient',
        security: [['bearerAuth' => []]],
        tags: ['Ingredients'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Sugar'),
                    new OA\Property(
                        property: 'tags',
                        type: 'array',
                        items: new OA\Items(type: 'string'),
                        example: ['contains_sugar']
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Ingredient created'),
            new OA\Response(response: 403, description: 'Forbidden'),
            new OA\Response(response: 422, description: 'Validation error'),
        ]
    )]
    public function store()
    {
    }

    #[OA\Put(
        path: '/api/ingredients/{id}',
        summary: 'Update ingredient',
        security: [['bearerAuth' => []]],
        tags: ['Ingredients'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Sugar Updated'),
                    new OA\Property(
                        property: 'tags',
                        type: 'array',
                        items: new OA\Items(type: 'string'),
                        example: ['contains_sugar']
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Ingredient updated'),
            new OA\Response(response: 403, description: 'Forbidden'),
            new OA\Response(response: 404, description: 'Ingredient not found'),
        ]
    )]
    public function update()
    {
    }

    #[OA\Delete(
        path: '/api/ingredients/{id}',
        summary: 'Delete ingredient',
        security: [['bearerAuth' => []]],
        tags: ['Ingredients'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))
        ],
        responses: [
            new OA\Response(response: 200, description: 'Ingredient deleted'),
            new OA\Response(response: 403, description: 'Forbidden'),
            new OA\Response(response: 404, description: 'Ingredient not found'),
        ]
    )]
    public function destroy()
    {
    }
}