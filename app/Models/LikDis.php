<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikDis extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
     protected $fillable = [
        'news_id','dislike', 'like_column'
    ];
}
