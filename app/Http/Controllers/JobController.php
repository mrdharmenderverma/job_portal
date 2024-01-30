<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;

class JobController extends Controller
{   
    // public function index(){

    //     $jobs = Job::where('status', 1);
    //     $jobs = $jobs->with('jobType')->orderBy('created_at', 'DESC')->paginate(10);
    // }

    public function jobs(Request $request){
        $categories = category::where('status', 1)->get();
        $jobTypes = JobType::where('status', 1)->get();

        //with the help of with we are calling jobtype relation
        $jobs = Job::where('status', 1);

        //search using keywords and title
        if (!empty($request->keyword)) {
            // $jobs = $jobs->orwhere('title', 'like', '%'.$request->keyword.'%');
            // $jobs = $jobs->orwhere('keywords', 'like', '%'.$request->keyword.'%');

            $jobs = $jobs->where(function($query) use($request){
                $query->orwhere('title', 'like', '%'.$request->keyword.'%');
                $query->orwhere('keywords', 'like', '%'.$request->keyword.'%');
            });
        }

        //search using location
        if (!empty($request->location)) {
            $jobs = $jobs->where('location', $request->location);
        }

        //search using category
        if (!empty($request->category)) {
            $jobs = $jobs->where('category_id', $request->category);
        }

        //search using Job Type
        $jobTypeArray = [];
        if (!empty($request->jobType)) {
            //1, 2, 3
            $jobTypeArray = explode(',', $request->jobType);

            $jobs = $jobs->whereIn('job_type_id', $jobTypeArray);
        }

        //search using experience
        if (!empty($request->experience)) {
            $jobs = $jobs->where('experience', $request->experience);
        }

        $jobs = $jobs->with(['jobType', 'category'])->orderBy('created_at', 'DESC')->paginate(9);

        return view('front.jobs', compact('categories', 'jobTypes', 'jobs', 'jobTypeArray'));
    }

    // This method will show job details page
    public function detail($id){

        $job = Job::Where(['id' => $id, 'status' => 1])->with('jobType')->first();

        if ($job == null) {
            abort(404);
        }
        return view('front.jobDetail', compact('job'));
        // return view('front.jobDetail', ['job' => $job]);
    }
}
