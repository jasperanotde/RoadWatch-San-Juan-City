<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Report;

class ReportSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'new_field',
        'location',
        'materials',
        'personnel',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function submissionsUpdate()
    {
        return $this->hasMany(ReportSubmissionUpdate::class);
    }
     
}