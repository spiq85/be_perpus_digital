<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'id_category';
    public $timestamp = false;
    protected $table = 'categories';

    protected $fillable = [
        'category_name'
    ];

    public function books()
    {
        return $this->hasMany(Book::class, 'id_category' , 'id_category');
    }
}
