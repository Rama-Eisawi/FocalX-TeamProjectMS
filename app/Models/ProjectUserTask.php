<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectUserTask extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_user_id',
        'task_id'
    ];
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function projectUser()
    {
        return $this->belongsTo(ProjectUser::class);
    }
}
