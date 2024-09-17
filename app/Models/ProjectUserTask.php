<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectUserTask extends Model
{
    use HasFactory;
    protected $table = 'project_user_task';

    protected $fillable = [
        'project_user_id',
        'task_id'
    ];
    /**
     * Defines an inverse one-to-many relationship with the Task model.
     * Each entry in the project_user_task table belongs to a specific task.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
    //-------------------------------------------------------------------------------
    /**
     * Defines an inverse one-to-many relationship with the ProjectUser model.
     * Each entry in the project_user_task table belongs to a specific user-project association.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function projectUser()
    {
        return $this->belongsTo(ProjectUser::class);
    }
}
