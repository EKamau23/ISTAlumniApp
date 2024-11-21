<?php

namespace App\Http\Controllers;

use App\Models\applied_job;
use Illuminate\Http\Request;

class AppliedJobs extends Controller
{
    public function index()
    {
        // Query to get job_id, job title, count of applicants, and the first applied_jobs id per job_id
        $jobs = applied_job::select('job_id', \DB::raw('MIN(id) as id'), \DB::raw('count(user_id) as applicant_count'))
            ->with('alumniJob')  // Eager load the job relationship to get job details
            ->groupBy('job_id')
            ->get();
    
        // Map the result to include job name, count of applicants, and applied_jobs id
        $jobs = $jobs->map(function ($job) {
            return [
                'id' => $job->id, // Include the first applied_jobs id per job_id
                'job_id' => $job->job_id,
                'job_name' => $job->alumniJob->job_title, // Assuming 'job_title' is the job title column in alumni_jobs
                'applicant_count' => $job->applicant_count,
            ];
        });
    
        return view('Action.appliedjobs.index', compact('jobs'));
    }
    
    


    public function show($id)
    {
        // Find the applied job by its ID
        $job = applied_job::with('alumniJob')->findOrFail($id);



        // Prepare data for the view
        return response()->json([
            'job_title' => $job->alumniJob->name, // Assuming 'name' is the job title column in alumni_jobs
            'company_name' => $job->alumniJob->company_name, // Assuming Company_Name is the Company olumn in alumni_jobs
            'user_info' => $job->user_info,
            'user_name' => $job->fname . ' ' . $job->lname,
        ]);
    }
}
