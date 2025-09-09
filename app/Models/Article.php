<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'user_id',
        'titre',
        'contenu',
        'image'
    ];

    public function auteur() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
