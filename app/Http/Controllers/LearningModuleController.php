<?php

namespace App\Http\Controllers;

use App\Models\LearningModule;
use Illuminate\Http\Request;

class LearningModuleController extends Controller
{
    public function index()
    {
        $modules = LearningModule::all();
        $categories = LearningModule::select('category')->distinct()->pluck('category');
        return view('modules.index', compact('modules', 'categories'));
    }

    public function show(LearningModule $module)
    {
        return view('modules.show', compact('module'));
    }
}
