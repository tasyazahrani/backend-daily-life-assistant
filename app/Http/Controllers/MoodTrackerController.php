<?php

namespace App\Http\Controllers;

use App\Models\Mood;
use App\Models\Diary;
use Illuminate\Http\Request;

class MoodTrackerController extends Controller
{
    // Menampilkan mood selection dan history
    public function index()
    {
        $moods = Mood::all(); // Ambil semua mood
        $diaries = Diary::with('mood')->get(); // Ambil semua diary dan mood terkait

        return view('mood', compact('moods', 'diaries'));
    }

    // Menyimpan entry mood dan diary
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'mood_id' => 'required|exists:moods,id',
            'entry' => 'required|string',
        ]);

        // Simpan data diary
        Diary::create([
            'mood_id' => $request->mood_id,
            'entry' => $request->entry,
        ]);

        return redirect()->route('mood')->with('success', 'Diary entry saved successfully!');
    }
}
