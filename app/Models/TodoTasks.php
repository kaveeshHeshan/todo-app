<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoTasks extends Model
{
    use HasFactory;

    protected $fillable = [
        'td_list_id',
        'title',
        'due_date',
        'due_time',
        'status',
    ];
}
