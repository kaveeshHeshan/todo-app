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

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['due_date_time'];

    public function listData()
    {
        return $this->belongsTo('App\Models\TodoList', 'td_list_id', 'id');
    }

    
    public function getDueDateTimeAttribute()
    {
        return $this->due_date." ".$this->due_time;
    }
}
