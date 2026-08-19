<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\LearningModule;
use App\Models\MasterNarrative;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        if (Session::get('is_admin')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $adminEmail = env('ADMIN_EMAIL', 'admin@padmasari.ai');
        $adminPassword = env('ADMIN_PASSWORD', 'admin123');

        if ($request->input('email') === $adminEmail && $request->input('password') === $adminPassword) {
            Session::put('is_admin', true);
            Session::put('admin_email', $adminEmail);
            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang kembali, Admin Padmasari AI!');
        }

        return back()->withErrors(['email' => 'Kredensial Admin tidak valid. Harap periksa email & password Anda.']);
    }

    public function dashboard()
    {
        if (!Session::get('is_admin')) {
            return redirect()->route('admin.login')->with('error', 'Akses ditolak. Silakan login sebagai Admin.');
        }

        $stories = Story::latest()->get();
        $modules = LearningModule::all();
        $masterNarrative = MasterNarrative::getActive();
        $supabaseUrl = env('SUPABASE_URL', 'https://jeajmpnrcducsvlxzmyi.supabase.co');

        return view('admin.dashboard', compact('stories', 'modules', 'masterNarrative', 'supabaseUrl'));
    }

    public function updateMasterNarrative(Request $request)
    {
        if (!Session::get('is_admin')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'core_topic' => 'required|string|max:255',
            'master_content' => 'required|string',
            'core_summary' => 'nullable|string',
            'world_rules' => 'required|string',
            'system_prompt' => 'required|string',
        ]);

        $master = MasterNarrative::getActive();
        $master->update([
            'title' => $request->input('title'),
            'core_topic' => $request->input('core_topic'),
            'master_content' => $request->input('master_content'),
            'core_summary' => $request->input('core_summary'),
            'world_rules' => $request->input('world_rules'),
            'system_prompt' => $request->input('system_prompt'),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Naskah Cerita Master & Parameters berhasil diperbarui!');
    }



    public function storeStory(Request $request)
    {
        if (!Session::get('is_admin')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'theme' => 'required|string',
            'target_audience' => 'required|string',
            'moral_lesson' => 'nullable|string',
            'content' => 'required|string',
        ]);

        Story::create([
            'title' => $request->input('title'),
            'prompt' => 'Dibuat langsung oleh Admin',
            'theme' => $request->input('theme'),
            'target_audience' => $request->input('target_audience'),
            'moral_lesson' => $request->input('moral_lesson'),
            'content' => $request->input('content'),
            'reads_count' => 0,
            'is_featured' => $request->has('is_featured'),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Cerita baru berhasil dipublikasikan oleh Admin!');
    }

    public function storeModule(Request $request)
    {
        if (!Session::get('is_admin')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
            'lesson_count' => 'required|integer|min:1',
            'duration_minutes' => 'required|integer|min:1',
            'difficulty' => 'required|string',
        ]);

        LearningModule::create([
            'title' => $request->input('title'),
            'category' => $request->input('category'),
            'description' => $request->input('description'),
            'lesson_count' => $request->input('lesson_count'),
            'duration_minutes' => $request->input('duration_minutes'),
            'difficulty' => $request->input('difficulty'),
            'icon' => 'book-open',
            'progress_percent' => 0,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Modul pembelajaran baru berhasil dibuat!');
    }

    public function destroyStory(Story $story)
    {
        if (!Session::get('is_admin')) {
            return redirect()->route('admin.login');
        }

        $story->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Cerita berhasil dihapus.');
    }

    public function destroyModule(LearningModule $module)
    {
        if (!Session::get('is_admin')) {
            return redirect()->route('admin.login');
        }

        $module->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Modul berhasil dihapus.');
    }

    public function editStory(Story $story)
    {
        if (!Session::get('is_admin')) {
            return redirect()->route('admin.login');
        }

        return view('admin.edit_story', compact('story'));
    }

    public function updateStory(Request $request, Story $story)
    {
        if (!Session::get('is_admin')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'theme' => 'required|string',
            'target_audience' => 'required|string',
            'moral_lesson' => 'nullable|string',
            'content' => 'required|string',
        ]);

        $story->update([
            'title' => $request->input('title'),
            'theme' => $request->input('theme'),
            'target_audience' => $request->input('target_audience'),
            'moral_lesson' => $request->input('moral_lesson'),
            'content' => $request->input('content'),
            'is_featured' => $request->has('is_featured'),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Cerita berhasil diperbarui oleh Admin!');
    }

    public function editModule(LearningModule $module)
    {
        if (!Session::get('is_admin')) {
            return redirect()->route('admin.login');
        }

        return view('admin.edit_module', compact('module'));
    }

    public function updateModule(Request $request, LearningModule $module)
    {
        if (!Session::get('is_admin')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
            'lesson_count' => 'required|integer|min:1',
            'duration_minutes' => 'required|integer|min:1',
            'difficulty' => 'required|string',
            'progress_percent' => 'required|integer|min:0|max:100',
        ]);

        $module->update([
            'title' => $request->input('title'),
            'category' => $request->input('category'),
            'description' => $request->input('description'),
            'lesson_count' => $request->input('lesson_count'),
            'duration_minutes' => $request->input('duration_minutes'),
            'difficulty' => $request->input('difficulty'),
            'progress_percent' => $request->input('progress_percent'),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Modul pembelajaran berhasil diperbarui!');
    }

    public function logout()
    {
        Session::forget('is_admin');
        Session::forget('admin_email');
        return redirect()->route('admin.login')->with('success', 'Anda telah keluar dari Portal Admin.');
    }
}
