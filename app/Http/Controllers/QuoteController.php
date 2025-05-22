<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quote;
use Carbon\Carbon;

class QuoteController extends Controller
{
    public function index()
    {
        // Ambil quote hari ini (berdasarkan tanggal)
        $today = Carbon::today()->toDateString();
        $todayQuote = Quote::whereDate('date', $today)->first();

        // Ambil quotes sebelumnya (tidak termasuk hari ini)
        $previousQuotes = Quote::whereDate('date', '<', $today)
            ->orderBy('date', 'desc')
            ->take(10)
            ->get();

        return view('quotes.daily', compact('todayQuote', 'previousQuotes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
            'author' => 'required|string'
        ]);

        Quote::create([
            'text' => $request->text,
            'author' => $request->author,
            'date' => now()
        ]);

        return redirect()->back()->with('success', 'Quote successfully added!');
    }
}
