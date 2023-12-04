<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ReportSubmission;

class ReportSubmissionUpdate extends Model
{
    use HasFactory;

    protected $table = 'update_report_submissions';
    
    protected $fillable = [
        'report_submission_id', 'actions_taken', 'remarks', 'photo',
    ];

    public function submission()
    {
        return $this->belongsTo(ReportSubmission::class);
    }

    public function actionsTakenArray()
    {
        return json_decode($this->actions_taken, true);
    }
}
