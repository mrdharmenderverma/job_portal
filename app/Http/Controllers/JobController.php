<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function jobs(){
        $categories = category::where('status', 1)->get();
        $jobTypes = JobType::where('status', 1)->get();

        //with the help of with we are calling jobtype relation
        $jobs = Job::where('status', 1)->with('jobType')->orderBy('created_at', 'DESC')->paginate(9);

        return view('front.jobs', compact('categories', 'jobTypes', 'jobs'));
    }

    // This method will show job details page
    public function detail($id){

        $job = Job::Where(['id' => $id, 'status' => 1]);

        if ($job == null) {
            abort(404);
        }
        return view('front.jobDetail', compact('job'));
        // return view('front.jobDetail', ['job' => $job]);
    }
}
