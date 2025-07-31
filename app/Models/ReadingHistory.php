<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReadingHistory extends Model
{
    use HasFactory;

    protected $table = 'reading_histories';

    protected $fillable = [
        'id_user',
        'id_book',
        'read_at'
    ];

    public $timestamp = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user' , 'id_user');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'id_book' , 'id_book');
    }
}
