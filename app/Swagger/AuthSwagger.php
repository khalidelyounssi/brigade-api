<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

class AuthSwagger
{
    #[OA\Post(
        path: "/api/register",
        summary: "Register new user",
        tags: ["Auth"]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["name","email","password","password_confirmation"],
            properties: [
                new OA\Property(property: "name", type: "string", example: "Amine"),
                new OA\Property(property: "email", type: "string", example: "amine@test.com"),
                new OA\Property(property: "password", type: "string", example: "123456"),
                new OA\Property(property: "password_confirmation", type: "string", example: "123456")
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: "User created"
    )]
    public function register() {}



    #[OA\Post(
        path: "/api/login",
        summary: "Login user",
        tags: ["Auth"]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["email","password"],
            properties: [
                new OA\Property(property: "email", type: "string", example: "amine@test.com"),
                new OA\Property(property: "password", type: "string", example: "123456")
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: "Login success"
    )]
    public function login() {}



    #[OA\Post(
        path: "/api/logout",
        summary: "Logout user",
        security: [["bearerAuth" => []]],
        tags: ["Auth"]
    )]
    #[OA\Response(
        response: 200,
        description: "Logout success"
    )]
    public function logout() {}



    #[OA\Get(
        path: "/api/user",
        summary: "Get authenticated user",
        security: [["bearerAuth" => []]],
        tags: ["Auth"]
    )]
    #[OA\Response(
        response: 200,
        description: "User profile"
    )]
    public function user() {}
}