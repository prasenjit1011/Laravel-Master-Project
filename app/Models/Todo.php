<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Todo extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'user_id',
        'name',
        'status',
        'details'
    ];
    
    function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}