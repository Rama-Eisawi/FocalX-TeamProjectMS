<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['project_name', 'project_desc'];

    /**
     * Defines a many-to-many relationship between the Project model and the User model.
     * This means a project can be associated with many users, and a user can be associated with many projects.
     * The relationship is stored in the 'project_user' pivot table, which connects the two models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user');
    }
    //-------------------------------------------------------------------------------
    /**
     * Defines a one-to-many relationship between the Project model and the Task model.
     * This means a project can have multiple tasks associated with it, but each task belongs to one project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
