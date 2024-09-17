<?php

namespace App\Services;

use App\Http\Responses\ApiResponse;
use App\Models\ProjectUser;
use App\Models\ProjectUserTask;
use App\Models\Task;

class TaskService
{
    /**
     * Summary of createTask
     * @param mixed $projectId
     * @param mixed $request
     * @param mixed $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function createTask($projectId, $request, $user)
    {
        // Check if the user is assigned as a manager for the project
        $isManager = ProjectUser::where([
            ['project_id', $projectId],
            ['user_id', $user->id],
            ['role', 'manager']
        ])->exists();

        // If the user is not a manager, return an unauthorized response
        if (!$isManager) {
            return ApiResponse::error('Only the project manager can create tasks.', 403, 'Unauthorized');
        }

        // Proceed with task creation if the user is a manager
        $task = Task::create(
            [
                'title' => $request->title,
                'desc' => $request->desc,
                'priority' => $request->priority,
                'due_date' => $request->due_date,
                'project_id' => $projectId,
            ]
        );

        return ApiResponse::success($task, 'Task created successfully!', 201);
    }

    public function assignRole($request, $projectId, $taskId, $userId, $user)
    {
        // Check if the user is assigned as a manager for the project
        $isManager = ProjectUser::where([
            ['project_id', $projectId],
            ['user_id', $user->id],
            ['role', 'manager']
        ])->exists();
        // If the user is not a manager, return an unauthorized response
        if (!$isManager) {
            return ApiResponse::error('Only the project manager can create tasks.', 403, 'Unauthorized');
        }

        // Check if the user exists in the project
        $projectUser = ProjectUser::where([
            ['project_id', $projectId],
            ['user_id', $userId]
        ])->first();

        if ($projectUser) {
            return ApiResponse::error('This user is already assigned a role.', 409, 'Duplicated ');
        }
        $projectUser = ProjectUser::create([
            'project_id' => $projectId,
            'user_id' => $userId,
        ]);
        // Set the role manually since it is guarded
        $projectUser->role = $request->role;
        $projectUser->save();
        // Assign the task to the user
        $assignedTask = ProjectUserTask::create([
            'project_user_id' => $projectUser->id,
            'task_id' => $taskId,
        ]);

        return ApiResponse::success($projectUser, 'Task assigned successfully!', 201);
    }
}
