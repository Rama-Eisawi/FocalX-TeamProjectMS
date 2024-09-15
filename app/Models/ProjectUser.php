<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectUser extends Model
{
    protected $fillable = [
        'user_id',
        'project_id',
        'role',
        'contribution_hours',
        'last_activity'
    ];

    use HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'project_user_task');
    }
}
