<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;
class Post extends Model
{
    use HasFactory;
    // +++++++++++++++++++ "Article" Fillable Columns in Database ++++++++++++++++++
    protected $fillable=[
        'title',
        'author',
        'body',
        'cover',
    ];
    // +++++++++++++++++++ Relationships : Relationship Between "Article" And "Images" ++++++++++++++++++
    // +++++++++++++++++++ 1:M Relationship : "1 article" has "many images"  ++++++++++++++++++
    public function images()
    {
        return $this->hasMany(Image::class);
    }

}
