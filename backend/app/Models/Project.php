<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Ensure User is imported

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // Changed from title to name
        'description',
        'demo_link',
        'github_link',
        'image',
        'status',
        'user_id', // Add user_id here
    ];

    /**
     * Get the user that owns the project.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
