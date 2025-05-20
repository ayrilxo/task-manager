<?php

namespace App\Http\Controllers;
use App\Models\Task;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Task::query();

        if ($request->query('filter') === 'incomplete') {
            $query->where('is_completed', false);
        }

        $tasks = $query->orderBy('created_at', 'desc')->get();

        //chart data

        $completedCount = Task::where('is_completed', true)->count();
        $pendingCount = Task::where('is_completed',false)->count();

        return view('tasks.index', compact('tasks','completedCount','pendingCount'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=> 'required',
            'deadline' => 'nullable|date',
        ]);
        Task::create($request->all());
          return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.edit', compact('task'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        // If the request has is_completed (like from Mark as Done form), update it directly
        if ($request->has('is_completed')) {
            $task->is_completed = $request->input('is_completed');
        }

        // For other updates like editing title and deadline
        if ($request->has('title')) {
            $request->validate([
                'title' => 'required',
                'deadline' => 'nullable|date',
            ]);
            $task->title = $request->input('title');
            $task->deadline = $request->input('deadline');
        }

        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task ->delete();
        return redirect()->route('tasks.index')->with('success','Task Deleted');
    }

     public function incomplete()
    {
        // Fetch only incomplete tasks, ordered by creation date
        $tasks = Task::where('is_completed', false)->orderBy('created_at', 'desc')->get();
        return view('tasks.index', compact('tasks'));
    }
}
