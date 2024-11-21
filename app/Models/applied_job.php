<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class applied_job extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_id',
        'name',
        'user_info',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function alumniJob()
    {
        return $this->belongsTo(ist_jobs::class, 'job_id');
    }
}
