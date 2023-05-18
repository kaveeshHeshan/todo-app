<?php

namespace App\Models;

use App\Models\TodoTasks;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TodoList extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
    ];

    // Get related tasks data
    public function tasksData()
    {
        return $this->hasMany(TodoTasks::class, 'td_list_id', 'id');
    }
}
