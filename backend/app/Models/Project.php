<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'description',
        'demo_link',
        'github_link',
        'image',
        'status',
    ];

    // Add accessor to handle both 'name' and 'title' fields
    public function getTitleAttribute($value)
    {
        return $value ?: $this->attributes['name'] ?? null;
    }

    public function getNameAttribute($value)
    {
        return $value ?: $this->attributes['title'] ?? null;
    }
}