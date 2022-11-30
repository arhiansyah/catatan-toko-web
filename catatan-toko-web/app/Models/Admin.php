<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id'
    ];

    public function store()
    {
        return $this->hasMany(Store::class);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
