<?php 

namespace App\GraphQL\Query;

use Closure;
use App\Models\Todo;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class TodoQuery extends Query
{
    protected $attributes = [
        'name' => 'posts',
    ];

    public function type(): Type
    {
        return Type::nonNull(Type::listOf(Type::nonNull(GraphQL::type('Post'))));
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id', 
                'type' => Type::int(),
            ],
            'title' => [
                'name' => 'title', 
                'type' => Type::string(),
            ]
        ];
    }

    public function resolve($root, $args)
    {        
        if (isset($args['id'])) {
            return Todo::whereId($args['id'])->get();
        }
        
        if (isset($args['title'])) {
            return Todo::whereTitle($args['title'])->get();
        }

        return Todo::all();
    }
}
