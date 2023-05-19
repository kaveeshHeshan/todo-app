<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\TodoList;
use App\Models\TodoTasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $todoLists = TodoList::with('tasksData')->get();

        $onComingTasks = TodoTasks::select('id', 'td_list_id', 'title', DB::raw('DATE(due_date) as due_date'), 'due_time', 'status',)
            ->with('listData')
            ->where('due_date', '>=', Carbon::now()->toDateString())
            ->where('due_date', '<=', Carbon::now()->addDays(3)->toDateString())
            ->where('status', '!=', 'complete')
            ->orderBy('due_date', 'ASC')
            ->get()
            ->groupBy('due_date');

            // return $onComingTasks;
            // // return $onComingTasks;

        return view('home', compact('todoLists', 'onComingTasks'));
    }
}
