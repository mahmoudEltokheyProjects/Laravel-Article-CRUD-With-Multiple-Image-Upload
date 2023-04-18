<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
class Image extends Model
{
    use HasFactory;
    // +++++++++++++++++++ "Image" Fillable Columns in Database ++++++++++++++++++
    protected $fillable=[
        'image',
        'post_id',
    ];
    // +++++++++++++++++++ Relationships : Relationship Between "Images" And "Article" ++++++++++++++++++
    // +++++++++++++++++++ 1:M Relationship : "1 image" Belongs to "1 article"  ++++++++++++++++++
    public function posts()
    {
        return $this->belongsTo(Post::class);
    }
}
