<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    // Read all entries
    public function read()
    {
        return Task::all();
    }

    // Read one entry
    public function readOne($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }
        return $task;
    }

    // Create one entry
    public function create(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:10',
            'protein' => 'required|integer|min:0|max:1000',
            'carbs' => 'required|integer|min:0|max:1000',
            'fat' => 'required|integer|min:0|max:1000',
        ]);

        return Task::create($validated);
    }

    // Update one entry
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:10',
            'protein' => 'required|integer|min:0|max:1000',
            'carbs' => 'required|integer|min:0|max:1000',
            'fat' => 'required|integer|min:0|max:1000',
        ]);

        $task->update($validated);

        return $task;
    }

    // Delete one entry
    public function delete($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        $task->delete();
        return response()->json(['message' => 'Task deleted']);
    }
}

?>