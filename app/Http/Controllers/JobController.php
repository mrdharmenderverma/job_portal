<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\JobType;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function job(){
        $categories = category::where('status', 1)->get();
        $jobTypes = JobType::where('status', 1)->get();

        return view('front.jobs', compact('categories', 'jobTypes'));
    }
}
