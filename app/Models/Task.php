<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'desc',
        'status',
        'priority',
        'due_date',
        'project_id',
    ];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function projectUsers()
    {
        return $this->belongsToMany(ProjectUser::class, 'project_user_task');
    }
}
