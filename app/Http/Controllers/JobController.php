<?php namespace App\Http\Controllers;

use App\Models\ist_jobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class JobController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return[
           new Middleware('permission:view job', only : ['index']),
           new Middleware('permission:create job', only : ['create','store']),
           new Middleware('permission:update job', only : ['update','edit']),
           new Middleware('permission:delete job', only : ['destroy']),
        ];
    }
    public function index()
    {
        $jobs = ist_jobs::all();
        return view('Action.jobs.index', [
            'jobs' => $jobs
        ]);
    }

    public function create()
    {
        return view('Action.jobs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'job_title' => 'required|string',
            'job_name' => 'required|string',
            'job_description' => 'required|string',
            'job_qualification' => 'required|string',
            'job_location' => 'required|string',
            'job_amount' => 'required|numeric',
        ]);

        ist_jobs::create($request->all());

        return redirect('/jobs')->with('status', 'Job created successfully');
    }

    public function edit($id)
    {
        $job = ist_jobs::findOrFail($id);
        return view('Action.jobs.edit', ['job' => $job]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'job_title' => 'required|string',
            'job_name' => 'required|string',
            'job_duration' => 'required|string',
            'job_type' => 'required|string',
            'job_description' => 'required|string',
            'job_qualification' => 'required|string',
            'job_location' => 'required|string',
            'job_amount' => 'required|numeric',
        ]);

        $job = ist_jobs::findOrFail($id);
        $job->update($request->all());

        return redirect('/jobs')->with('status', 'Job updated successfully');
    }

    public function destroy($id)
    {
        $job = ist_jobs::findOrFail($id);
        $job->delete();

        return redirect('/jobs')->with('status', 'Job deleted successfully');
    }
}
