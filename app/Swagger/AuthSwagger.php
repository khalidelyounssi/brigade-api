<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Tag(
    name: 'Auth',
    description: 'Authentication endpoints'
)]
class AuthSwagger
{
    #[OA\Post(
        path: '/api/register',
        summary: 'Register a new user',
        tags: ['Auth'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['name', 'email', 'password', 'role'],
                properties: [
                    new OA\Property(property: 'name', type: 'string', example: 'Amine'),
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'amine@gmail.com'),
                    new OA\Property(property: 'password', type: 'string', example: '123456'),
                    new OA\Property(property: 'role', type: 'string', example: 'client'),
                    new OA\Property(
                        property: 'dietary_tags',
                        type: 'array',
                        items: new OA\Items(type: 'string'),
                        example: ['no_sugar', 'gluten_free']
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'User registered successfully'
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error'
            ),
        ]
    )]
    public function register()
    {
    }

    #[OA\Post(
        path: '/api/login',
        summary: 'Login user',
        tags: ['Auth'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['email', 'password'],
                properties: [
                    new OA\Property(property: 'email', type: 'string', format: 'email', example: 'amine@gmail.com'),
                    new OA\Property(property: 'password', type: 'string', example: '123456'),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Login successful'
            ),
            new OA\Response(
                response: 401,
                description: 'Invalid credentials'
            ),
        ]
    )]
    public function login()
    {
    }

    #[OA\Post(
        path: '/api/logout',
        summary: 'Logout user',
        security: [['bearerAuth' => []]],
        tags: ['Auth'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Logout successful'
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthorized'
            ),
        ]
    )]
    public function logout()
    {
    }

    #[OA\Get(
        path: '/api/me',
        summary: 'Get authenticated user',
        security: [['bearerAuth' => []]],
        tags: ['Auth'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Authenticated user'
            ),
            new OA\Response(
                response: 401,
                description: 'Unauthorized'
            ),
        ]
    )]
    public function me()
    {
    }
}