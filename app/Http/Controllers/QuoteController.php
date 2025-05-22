<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;
use Carbon\Carbon;

class QuoteController extends Controller
{
    /**
     * Display daily quotes page
     */
    public function index()
    {
        $today = Carbon::today();

        $todayQuote = Quote::whereDate('quote_date', $today)->first();

        $previousQuotes = Quote::whereDate('quote_date', '<', $today)
            ->orderBy('quote_date', 'desc')
            ->limit(10)
            ->get();

        return view('user.daily-quotes', compact('todayQuote', 'previousQuotes'));
    }

    /**
     * Store a new quote
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'text' => 'required|string|min:10|max:1000',
            'author' => 'nullable|string|max:255',
        ]);

        $today = Carbon::today();

        $existingQuote = Quote::whereDate('quote_date', $today)->first();

        if ($existingQuote) {
            return back()->with('warning', 'A quote for today already exists.');
        }

        Quote::create([
            'text' => trim($validated['text']),
            'author' => $validated['author'] ? trim($validated['author']) : 'Anonymous',
            'quote_date' => $today,
            'is_favorite' => false,
        ]);

        return back()->with('success', 'Quote added successfully!');
    }

    /**
     * Toggle favorite status of a quote
     */
    public function toggleFavorite($id)
    {
        $quote = Quote::findOrFail($id);
        $quote->is_favorite = !$quote->is_favorite;
        $quote->save();

        $message = $quote->is_favorite ? 'Added to favorites.' : 'Removed from favorites.';
        return back()->with('success', $message);
    }

    /**
     * Show favorite quotes
     */
    public function favorites()
    {
        $favoriteQuotes = Quote::where('is_favorite', true)
            ->orderBy('quote_date', 'desc')
            ->paginate(10);

        return view('user.favorite-quotes', compact('favoriteQuotes'));
    }

    /**
     * Delete a quote
     */
    public function destroy($id)
    {
        $quote = Quote::findOrFail($id);
        $quote->delete();

        return back()->with('success', 'Quote deleted.');
    }

    /**
     * Get a random quote (API)
     */
    public function random()
    {
        $randomQuote = Quote::inRandomOrder()->first();

        if (!$randomQuote) {
            return response()->json(['message' => 'No quotes found'], 404);
        }

        return response()->json([
            'success' => true,
            'quote' => $randomQuote
        ]);
    }
}
