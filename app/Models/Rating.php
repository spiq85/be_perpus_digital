<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $primaryKey = 'id_rating';
    protected $table = 'ratings';

    protected $fillable = [
        'id_user',
        'id_book',
        'rating',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user' , 'id_user');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'id_book' , 'id_book');
    }
}
