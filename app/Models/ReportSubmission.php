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


public function materialsArray()
{
    return json_decode($this->materials, true);
}

public function personnelArray()
{
    return json_decode($this->personnel, true);
}


    public function report()
    {
        return $this->belongsTo(Report::class);
    }
    
    
}