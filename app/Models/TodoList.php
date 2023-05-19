<?php

namespace App\Models;

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
        return $this->hasMany('App\Models\TodoTasks', 'td_list_id', 'id');
    }
}
