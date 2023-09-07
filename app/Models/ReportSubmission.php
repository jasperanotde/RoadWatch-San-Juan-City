<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'new_field',
        'date',
        'location',
        'materials',
        'personnel',
        'materials',
        'actions_taken',
        'remarks',
    ];

    public function actionsTakenArray()
{
    return json_decode($this->actions_taken, true);
}

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
    
    
}