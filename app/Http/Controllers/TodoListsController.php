<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use App\Models\TodoTasks;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTodoListRequest;

class TodoListsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.todo_lists.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    // 
    public function store(StoreTodoListRequest $request)
    {
        $newToDoList = TodoList::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if (count($request->tasks)) {
            foreach ($request->tasks as $task) {

                TodoTasks::create([
                    'td_list_id' => $newToDoList->id,
                    'title' => $task['title'],
                    'due_date' => $task['due_date'],
                    'due_time' => $task['due_time'],
                    'status' => $task['status'] ?? 'pending',
                ]);                
            }
        }

        return redirect('/home')->with('success', 'Todo list and tasks saved successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
