<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ist_jobs extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_title',
        'job_description',
        'job_qualification',
        'job_location',
        'job_name',
        'job_amount',
    ];

    public function appliedJobs()
    {
        return $this->hasMany(applied_job::class);
    }
}
