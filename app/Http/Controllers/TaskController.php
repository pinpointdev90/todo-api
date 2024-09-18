<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // タスクの一覧を取得
    public function index()
    {
        return Task::all();
    }

    // 新しいタスクを作成
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $task = Task::create($validatedData);
        return response()->json($task, 201);
    }

    // IDでタスクを取得
    public function show($id)
    {
        $task = Task::find($id);
        if ($task) {
            return $task;
        }
        return response()->json(['message' => 'Task not found'], 404);
    }

    // タスクを更新
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        if ($task) {
            $validatedData = $request->validate([
                'title' => 'sometimes|required|string',
                'description' => 'sometimes|nullable|string',
                'isDone' => 'sometimes|required|boolean',
            ]);

            $task->update($validatedData);
            return $task;
        }
        return response()->json(['message' => 'Task not found'], 404);
    }

    // タスクを削除
    public function destroy($id)
    {
        $task = Task::find($id);
        if ($task) {
            $task->delete();
            return response()->json(null, 204);
        }
        return response()->json(['message' => 'Task not found'], 404);
    }
}
