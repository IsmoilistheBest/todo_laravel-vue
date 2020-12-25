<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user_id = auth()->user()->id;
        $todo = Todo::where('user_id', $user_id)->get();
        // dd($todo);
        return $todo;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $todo = new Todo();
        $check = Todo::where('title', $request->title)->first();
        // dd($check);
        if ($check->title == $request->title)
        {
            // dd($check->title);
            $error = false;
            return $error->with('error', 'error');
        }
        else
        {
            $todo->user_id = auth()->user()->id;
            $todo->title = $request->title;
            $todo->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Todo  $todo
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
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $todo = Todo::findOrFail($id);

        $todo->completed = $request->completed;
        $todo->title = $request->title;
        // dd($todo);
        $todo->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->delete();
        $user_id = auth()->user()->id;
        $todo = Todo::where('user_id', $user_id)->get();
        return $todo;
    }
}
