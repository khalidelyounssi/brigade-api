<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

class CategorieSwagger
{
    #[OA\Post(
        path: "/api/categories",
        summary: "Create category",
        security: [["bearerAuth" => []]],
        tags: ["Categories"]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["name"],
            properties: [
                new OA\Property(property: "name", type: "string", example: "Desserts")
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: "Category created"
    )]
    public function store() {}



    #[OA\Get(
        path: "/api/categories",
        summary: "List categories",
        security: [["bearerAuth" => []]],
        tags: ["Categories"]
    )]
    #[OA\Response(
        response: 200,
        description: "Categories list"
    )]
    public function index() {}



    #[OA\Get(
        path: "/api/categories/{id}",
        summary: "Show category",
        security: [["bearerAuth" => []]],
        tags: ["Categories"]
    )]
    #[OA\Parameter(
        name: "id",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\Response(
        response: 200,
        description: "Category found"
    )]
    public function show() {}



    #[OA\Put(
        path: "/api/categories/{id}",
        summary: "Update category",
        security: [["bearerAuth" => []]],
        tags: ["Categories"]
    )]
    #[OA\Parameter(
        name: "id",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\Response(
        response: 200,
        description: "Category updated"
    )]
    public function update() {}



    #[OA\Delete(
        path: "/api/categories/{id}",
        summary: "Delete category",
        security: [["bearerAuth" => []]],
        tags: ["Categories"]
    )]
    #[OA\Parameter(
        name: "id",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\Response(
        response: 200,
        description: "Category deleted"
    )]
    public function destroy() {}
}