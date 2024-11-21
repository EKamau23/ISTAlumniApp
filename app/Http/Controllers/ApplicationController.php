<?php
namespace App\Http\Controllers;

use App\Models\applied_job;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function submitApplication(Request $request, $applyId)
    {
        // Validate the incoming request, except for 'job_id' since it will be set by $applyId
        $validatedData = $request->validate([
            'fname' => 'string|max:255',
            'user_info' => 'string|max:255',
        ]);

        // Manually set 'job_id' to the value of $applyId
        $validatedData['job_id'] = $applyId;

     
        $user = auth()->user();
        $appliedJob = new applied_job();
        $appliedJob->user_id = $user->id;
        $appliedJob->job_id = $validatedData['job_id'];
        $appliedJob->name = $validatedData['fname'];
        $appliedJob->user_info = $validatedData['user_info'];
        $appliedJob->save();
        

        return redirect('/dashboard');
    }
}
