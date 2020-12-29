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
        $check_id = auth()->user()->id;
        $this->validate($request, [
            'title' => 'required|max:255|min:3'
        ]);
        $check = Todo::where('title', $request->title)
                        ->where('user_id', $check_id)
                        ->where('completed', 0)
                        ->count();

        if (!$check)
        {
            $todo->user_id = auth()->user()->id;
            $todo->title = $request->title;
            $todo->save();
        }
        else
        {
            return response()->json([
                'status' => 'error',
                'msg'   => 'Hey dude you have another uncompleted task like this one'
            ]);
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
        // checking existing description
        if($request->description)
        {
            dd("1");
            $this->validate($request, [
                'description' => 'required|min:3'
            ]);

            $todo->description = $request->description;
            $todo->save();
        }
        // checking existing title
        if($request->title)
        {
            $this->validate($request, [
                'title' => 'required|max:255|min:3'
            ]);
            if($todo->title == $request->title)
            {
                return true;
            }
            $check_id = auth()->user()->id;
            $check = Todo::where('title', $request->title)
                                ->where('user_id', $check_id)
                                ->where('completed', 0)
                                ->count();

            if(!$check)
            {
                $todo->title = $request->title;
                $todo->save();
            }
            else
            {
                return response()->json([
                    'status' => 'error',
                    'msg'   => 'Hey dude you have another uncompleted task like this one'
                ]);
            }

        }
        // checking existing completed
        if($request->completed || !$request->completed)
        {
            $todo->completed = $request->completed;
            $todo->save();
        }
        // if when editing user type nothing give the error
        if($request->title == null)
        {
            return response()->json([
                'status'    => 'error',
                'msg'       => 'Hey dude you cannot save empty todo'
            ]);
        }
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
