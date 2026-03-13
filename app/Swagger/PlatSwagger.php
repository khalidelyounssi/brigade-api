<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

class PlatSwagger
{
    #[OA\Post(
        path: "/api/plats",
        summary: "Create plat",
        security: [["bearerAuth" => []]],
        tags: ["Plats"]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ["name","price","category_id"],
            properties: [
                new OA\Property(property: "name", type: "string", example: "Pizza"),
                new OA\Property(property: "description", type: "string", example: "Pizza fromage"),
                new OA\Property(property: "price", type: "number", example: 10),
                new OA\Property(property: "category_id", type: "integer", example: 1)
            ]
        )
    )]
    #[OA\Response(
        response: 201,
        description: "Plat created"
    )]
    public function store() {}



    #[OA\Get(
        path: "/api/plats",
        summary: "List plats",
        security: [["bearerAuth" => []]],
        tags: ["Plats"]
    )]
    #[OA\Response(
        response: 200,
        description: "Plats list"
    )]
    public function index() {}



    #[OA\Get(
        path: "/api/plats/{id}",
        summary: "Show plat",
        security: [["bearerAuth" => []]],
        tags: ["Plats"]
    )]
    #[OA\Parameter(
        name: "id",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\Response(
        response: 200,
        description: "Plat found"
    )]
    public function show() {}



    #[OA\Put(
        path: "/api/plats/{id}",
        summary: "Update plat",
        security: [["bearerAuth" => []]],
        tags: ["Plats"]
    )]
    #[OA\Parameter(
        name: "id",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\Response(
        response: 200,
        description: "Plat updated"
    )]
    public function update() {}



    #[OA\Delete(
        path: "/api/plats/{id}",
        summary: "Delete plat",
        security: [["bearerAuth" => []]],
        tags: ["Plats"]
    )]
    #[OA\Parameter(
        name: "id",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\Response(
        response: 200,
        description: "Plat deleted"
    )]
    public function destroy() {}
}