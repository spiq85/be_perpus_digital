<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $primaryKey = 'id_author';
    protected $table = 'authors';

    public $timestamp = false;

    protected $fillable = [
        'author_name',
    ];

    public function books()
    {
        return $this->hasMany(Book::class, 'id_author' , 'id_author');
    }

}
