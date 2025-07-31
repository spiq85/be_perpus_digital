<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Book extends Model
{
    use InteractsWithMedia;

    protected $primaryKey = 'id_book';
    protected $table = 'books';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'rating_counts',
        'id_category',
        'id_author',
        'id_publisher',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category' , 'id_category');
    }

    public function author()
    {
        return $this->belongsTo(Author::class, 'id_author' , 'id_author');
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class, 'id_publisher', 'id_publisher');  
    }

    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorites' , 'id_book' , 'id_user');
    }

    public function readingHistory()
    {
        return $this->hasMany(ReadingHistory::class, 'id_book', 'id_book');
    }
}
