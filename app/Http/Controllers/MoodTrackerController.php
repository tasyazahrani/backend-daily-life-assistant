<?php

namespace App\Http\Controllers;

use App\Models\Mood;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MoodTrackerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Ambil mood hanya milik user yang login, diurutkan dari yang terbaru
        $moods = Auth::user()->moods()->latest()->get();
        
        return view('mood', compact('moods'));
    }

    public function create()
    {
        return view('mood'); // atau view yang sesuai untuk form create
    }

    public function show($id)
    {
        $mood = Auth::user()->moods()->findOrFail($id);
        return view('mood.show', compact('mood'));
    }

    public function edit($id)
    {
        $mood = Auth::user()->moods()->findOrFail($id);
        return view('mood.edit', compact('mood'));
    }

    public function store(Request $request)
{
    $request->validate([
        'mood' => 'required',
        'emoji' => 'required',
        'diary_text' => 'required',
    ]);

    Mood::create([
        'user_id' => Auth::id(),
        'mood' => $request->mood,
        'emoji' => $request->emoji,
        'diary_text' => $request->diary_text,
    ]);

        return redirect()->route('moods.index')->with('success', 'Mood berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'diary_text' => 'required|string|max:1000',
        ]);

        // Cari mood yang hanya milik user yang login
        $mood = Auth::user()->moods()->findOrFail($id);
        
        $mood->update([
            'diary_text' => $request->diary_text,
        ]);

        return redirect()->route('moods.index')->with('success', 'Mood berhasil diupdate!');
    }

    public function destroy($id)
    {
        try {
            // Hapus mood yang hanya milik user yang login
            $mood = Auth::user()->moods()->findOrFail($id);
            $mood->delete();

            return redirect()->route('moods.index')->with('success', 'Mood berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('moods.index')->with('error', 'Gagal menghapus mood!');
        }
    }
}