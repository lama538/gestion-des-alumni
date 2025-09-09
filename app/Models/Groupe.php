<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    protected $fillable = [
        'nom',
        'description',
        'user_id'
    ];

    public function membres() {
        return $this->belongsToMany(User::class);
    }

    public function createur() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
