<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatusEnum;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{

    public function store(TaskRequest $request)
    {
        user()->tasks()->create($request->all());

        return back();
    }

    public function update(Task $task, TaskRequest $request)
    {
        $this->authorize('update', $task);

        $task->update($request->validated());

        return back();
    }

    public function delete(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return back();
    }

}
