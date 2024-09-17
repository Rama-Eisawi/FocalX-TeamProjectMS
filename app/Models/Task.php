<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'task_desc',
        'status',
        'priority',
        'due_date',
        'project_id',
    ];
    /**
     * Defines an inverse one-to-many relationship with the Project model.
     * Each task belongs to a specific project, indicated by the foreign key 'project_id'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    //-------------------------------------------------------------------------------
    /**
     * Defines a many-to-many relationship between the Task model and the ProjectUser model.
     * A task can be associated with multiple users working on the project,
     * through the 'project_user_task' pivot table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function projectUsers()
    {
        return $this->belongsToMany(ProjectUser::class, 'project_user_task');
    }
    //-------------------------------------------------------------------------------
    /**
     * Accessor for `due_date`
     * This formats the `due_date` when it is retrieved (get).
     */
    public function getDueDateAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i'); // i for minutes
    }
    //-------------------------------------------------------------------------------
    /**
     * Mutator for `due_date`
     * This formats the `due_date` when it is being set (before saving to the database).
     */
    public function setDueDateAttribute($value)
    {
        $this->attributes['due_date'] = Carbon::createFromFormat('d-m-Y H:i', $value)->format('Y-m-d H:i:s');
    }
}
