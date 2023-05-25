<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tag;
use App\Models\LikDis;

class News extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'link', 'img', 'description', 'author', 'date_rss'];
    
      public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    
    public function likes()
    {
        return $this->hasMany(LikDis::class);
    }
    
}
