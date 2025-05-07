<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        return response()->json(Todo::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'task' => 'required|string',
            'date' => 'nullable|string',
        ]);

        $todo = Todo::create([
            'task' => $request->task,
            'date' => $request->date,
            'completed' => false,
        ]);

        return response()->json($todo, 201);
    }

    public function update(Request $request, Todo $todo)
    {
        $todo->update($request->only('task', 'date', 'completed'));
        return response()->json($todo);
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return response()->json(null, 204);
    }
}
