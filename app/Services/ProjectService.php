<?php

namespace App\Services;

use App\Http\Responses\ApiResponse;
use App\Models\ProjectUser;
use App\Models\Project;
use App\Models\User;

class ProjectService
{
    public function createProjcet($data)
    {
        return Project::create($data);
    }
    /**
     * Assign a user as a manager to a project.
     *
     * @param int $projectId
     * @param int $userId
     * @return mixed
     */
    public function assignManager(int $projectId, int $userId)
    { // Retrieve the selected user
        $selectedUser = User::findOrFail($userId);

        // Prevent assigning an admin as a manager
        if ($selectedUser->is_admin == 1) {
            return ApiResponse::error('Cannot assign an admin as a project manager.', 400, 'Invalid Assignment');
        }
        // Check if the user is already assigned as a manager for the project
        $alreadyAssigned = ProjectUser::where([
            ['project_id', $projectId],
            ['user_id', $userId],
            ['role', 'manager']
        ])->exists();

        if ($alreadyAssigned) {
            return ApiResponse::error('User is already assigned as a manager for this project.', 400, 'Duplicate Assignment');
        }

        // Assign the user to the project with the 'manager' role
        $assigned = ProjectUser::create([
            'project_id' => $projectId,
            'user_id' => $userId,
            'role' => 'manager',
        ]);

        return ApiResponse::success($assigned, 'User assigned as project manager successfully!', 201);
    }
}
