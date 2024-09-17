<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectFormRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Create a new project only by admin
     */
    public function store(ProjectFormRequest $request)
    {
        $project = $this->projectService->createProjcet($request->validated());
        return ApiResponse::success($project, 'Project created successfully!', 201);
    }
    //---------------------------------------------------------------------------------------
    /**
     * Assign a manager role for user by admin
     */
    public function assignManager(Request $request, $projectId, $userId)
    {
        $user = Auth::user();
        if ($user->is_admin != 1) {
            return ApiResponse::error('Only admin can assign a project to manager', 401, 'Unauthorized');
        }
        return $this->projectService->assignManager($projectId, $userId);
    }
    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
