<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Todo::query();

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Search by title and details

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'LIKE', '%' . $request->input('search') . '%')
                  ->orWhere('details', 'LIKE', '%' . $request->input('search') . '%');
            });
        }

        // Sort by column (default to created_at)
        $sortBy = $request->input('sort_by', 'created_at');
        $order = $request->input('order', 'asc');
        $query->orderBy($sortBy, $order);

        return response()->json($query->get(), 200);

    }

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         // Validate input
         $validated = $request->validate([
            'title' => 'required|string|max:255',
            'details' => 'nullable|string',
            'status' => 'required|in:completed,in progress,not started',
        ]);

           // Create todo
           $todo = Todo::create($validated);

           return response()->json([
               'message' => 'Todo created successfully',
               'data' => $todo,
           ], 201);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find the todo
        $todo = Todo::findOrFail($id);

        return response()->json($todo, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         // Find the todo
         $todo = Todo::findOrFail($id);
          // Validate input
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'details' => 'nullable|string',
            'status' => 'sometimes|required|in:completed,in progress,not started',
        ]);

          // Update todo
          $todo->update($validated);

          return response()->json([
              'message' => 'Todo updated successfully',
              'data' => $todo,
          ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         // Find the todo
         $todo = Todo::findOrFail($id);

         // Delete todo
         $todo->delete();
 
         return response()->json([
             'message' => 'Todo deleted successfully',
         ], 200);
    }
}
