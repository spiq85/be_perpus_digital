<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    protected $primaryKey = 'id_publisher';
    protected $table = 'publishers';

    public $timestamp = false;

    protected $fillable = [
        'publisher_name',
    ];

    public function books()
    {
        return $this->hasMany(Book::class, 'id_publisher' , 'id_publisher');
    }
}
