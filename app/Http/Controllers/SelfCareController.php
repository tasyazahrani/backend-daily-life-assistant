<?php

namespace App\Http\Controllers;

use App\Models\SelfCareActivity;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SelfCareController extends Controller
{
    public function index()
    {
        $today = today();
        $userId = auth()->id();

        $activities = SelfCareActivity::where('user_id', $userId)
            ->where('date', $today)
            ->get();

        $week = collect();
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::now()->startOfWeek()->addDays($i);
            $total = SelfCareActivity::where('user_id', $userId)->where('date', $date)->count();
            $done = SelfCareActivity::where('user_id', $userId)->where('date', $date)->where('is_checked', true)->count();
            $week->push(['day' => $date->format('D'), 'score' => "$done/$total"]);
        }

        return view('selfcare', [
            'activities' => $activities,
            'weekly' => $week,
        ]);
    }

    public function store(Request $request)
    {
        SelfCareActivity::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'description' => 'Custom activity',
            'is_custom' => true,
            'date' => today(),
        ]);

        return redirect()->back();
    }

    public function toggle($id)
    {
        $activity = SelfCareActivity::where('user_id', auth()->id())->findOrFail($id);
        $activity->is_checked = !$activity->is_checked;
        $activity->save();

        return redirect()->back();
    }
}