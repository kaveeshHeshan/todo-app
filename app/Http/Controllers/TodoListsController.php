<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use App\Models\TodoTasks;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTodoListRequest;
use App\Http\Requests\UpdateTodoListRequest;

class TodoListsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response(['lists' => []]);
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
            'user_id' => auth()->user()->id,
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
        $todoList = TodoList::findOrFail($id);
        return view('pages.todo_lists.show', compact('todoList'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $todoList = TodoList::findOrFail($id);
        return view('pages.todo_lists.edit', compact('todoList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTodoListRequest $request, string $id)
    {

        $updateToDoList = TodoList::findOrFail($id);
        $updateToDoList->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if (count($request->tasks)) {
            foreach ($request->tasks as $task) {

                if (!is_null($task['r_id'])) {

                    $existingTask = TodoTasks::findOrFail($task['r_id']);
                    
                    if (!is_null($existingTask)) {
                        $existingTask->update([
                            'td_list_id' => $updateToDoList->id,
                            'title' => $task['title'],
                            'due_date' => $task['due_date'],
                            'due_time' => $task['due_time'],
                            'status' => $task['status'] ?? 'pending',
                        ]);
                    }

                } else {
                    TodoTasks::create([
                        'td_list_id' => $updateToDoList->id,
                        'title' => $task['title'],
                        'due_date' => $task['due_date'],
                        'due_time' => $task['due_time'],
                        'status' => $task['status'] ?? 'pending',
                    ]);
                }
                      
            }
        }

        return redirect('/home')->with('success', 'Todo list and tasks updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $list = TodoList::findOrFail($id);
        TodoTasks::where('td_list_id', $id)->delete();
        $list->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'List and related tasks removed successfully!'
        ])->setStatusCode(200);
    }

    /**
     * Remove the specified task from list.
     */
    public function deleteTask(string $id)
    {
        $task = TodoTasks::findOrFail($id);
        $task->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Task removed successfully!'
        ])->setStatusCode(200);
    }
}
