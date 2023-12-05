<?php

namespace App\GraphQL\Type;

use GraphQL;
use App\Models\Todo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class TodoType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Post',
        'description'   => 'A post',
        'model'         => Post::class,
    ];

    public function args(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The id of the post',
            ],
            'title' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The title of post',
            ],
        ];
    }
}