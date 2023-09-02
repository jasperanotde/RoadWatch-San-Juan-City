<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionSlip extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', // Add 'title' to the fillable array
        'description',
    ];

    

    
}
