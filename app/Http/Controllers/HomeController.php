<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {   
        $categories = category::where('status', 1)
                    ->orderBy('name', 'ASC')
                    ->take(8)->get();

        // $latestJob = JobType::where('status', 1)->get();

        $featuredJobs = Job::where('status', 1)
                        ->orderBy('created_at', 'DESC')
                        ->with('jobType')
                        ->where('isFeatured', 1)
                        ->take(6)->get();

        $latestJobs = Job::where('status', 1)
                        ->with('jobType')
                        ->orderBy('created_at', 'DESC')
                        ->take(6)->get();

        return view('front.home', compact('categories', 'latestJobs', 'featuredJobs'));
    }
}
