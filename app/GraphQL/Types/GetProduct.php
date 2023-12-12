<?php

//create query :
declare(strict_types=1);

namespace App\GraphQL\Types;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class GetProduct extends GraphQLType
{
    protected $attributes = [
        'name' => 'GetProduct',
        'description' => 'A type'
    ];

    public function fields(): array
    {
        return [
            "product_id" => [
                "type" => Type::int(),
                "description" => 'produt_id of product',
            ],
            "product_name" => [
                "type" => Type::string(),
                "description" => 'product_name of produc',
            ],
            "product_description" => [
                "type" => Type::string(),
                "description" => 'product_description of produc',
            ],
        ];
    }
}