<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskFormRequest;
use App\Http\Responses\ApiResponse;
use App\Models\ProjectUser;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }
    /**
     * Get all user task related to a specific project
     */
    public function index($projectId)
    {
        $userId = Auth::user();
        $user = User::findOrFail($userId->id);


        // Fetch tasks for this user related to the specific project
        $tasks = $user->tasks()->where('tasks.project_id', $projectId)->get();
        return ApiResponse::success($tasks, 'Retreive your tasks!', 200);
    }

    /**
     * Create a new task only by the manager of the specific project
     */
    public function store(TaskFormRequest $request, $projectId)
    {
        $user = Auth::user();
        return $this->taskService->createTask($projectId, $request, $user);
    }
    //----------------------------------------------------------------------------
    public function assignRole(Request $request, $projectId, $taskId, $userId)
    {
        $user = Auth::user();
        return $this->taskService->assignRole($request, $projectId, $taskId, $userId, $user);
    }
    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
