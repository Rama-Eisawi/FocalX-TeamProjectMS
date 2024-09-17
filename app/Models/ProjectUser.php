<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectUser extends Model
{
    protected $table = 'project_user';
    protected $fillable = [
        'user_id',
        'project_id',
        'contribution_hours',
    ];
    protected $guarded = ['role', 'last_activity'];

    use HasFactory;
    /**
     * Defines an inverse one-to-many relationship with the User model.
     * Each entry in the project_user table belongs to a single user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //-------------------------------------------------------------------------------
    /**
     * Defines an inverse one-to-many relationship with the Project model.
     * Each entry in the project_user table belongs to a single project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    /**
     * Defines a many-to-many relationship between the ProjectUser and Task models.
     * This indicates that a user (associated with a project) can be linked to many tasks,
     * through the 'project_user_task' pivot table.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'project_user_task');
    }
}
