<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $recentStories = Story::latest()->take(5)->get();

        $stats = [
            'stories_created' => Story::count(),
            'learning_hours' => 14.5,
            'certificates_earned' => 2,
        ];

        return view('dashboard', compact('recentStories', 'stats'));
    }
}
