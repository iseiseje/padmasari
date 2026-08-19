<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\LearningModule;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredStories = Story::where('is_featured', true)->latest()->take(3)->get();
        $totalStories = Story::count();
        $totalModules = LearningModule::count();

        return view('home', compact(
            'featuredStories',
            'totalStories',
            'totalModules'
        ));
    }
}
