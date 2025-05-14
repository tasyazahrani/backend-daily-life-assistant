<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
{
    $todos = Todo::latest()->get();
    return view('todos', compact('todos'));
}

public function store(Request $request)
{
    $request->validate(['task' => 'required']);
    Todo::create(['task' => $request->task, 'is_completed' => false]);
    return redirect('/todos');
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