<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\LearningModule;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $recentStories = Story::latest()->take(5)->get();
        $modules = LearningModule::all();

        $stats = [
            'stories_created' => Story::count(),
            'modules_completed' => LearningModule::where('progress_percent', 100)->count(),
            'active_modules' => LearningModule::where('progress_percent', '>', 0)->where('progress_percent', '<', 100)->count(),
            'learning_hours' => 14.5,
            'certificates_earned' => 2,
        ];

        return view('dashboard', compact('recentStories', 'modules', 'stats'));
    }
}
