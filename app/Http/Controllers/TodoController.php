<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
{
    $todos = Todo::where('user_id', auth()->id())->get(); // hanya todo milik user login
    return view('todos', compact('todos'));
}


public function store(Request $request)
{
    $request->validate([
        'task' => 'required|string|max:255',
    ]);

    Todo::create([
        'task' => $request->task,
        'user_id' => auth()->id(), // ← Simpan ID user yang login
    ]);

    return redirect()->back();
}


public function toggle(Todo $todo)
{
    $todo->update(['is_completed' => !$todo->is_completed]); // Toggle the completion status
    return redirect('/todos');
}


public function destroy(Todo $todo)
{
    $todo->delete();
    return redirect('/todos');
}

public function update(Request $request, Todo $todo)
{
    $request->validate(['task' => 'required']);
    $todo->update(['task' => $request->task]);
    return redirect('/todos');
}

}