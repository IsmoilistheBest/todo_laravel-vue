@extends('layouts.app')


@section('content')
    <div class="todo-body">
        <div class="w-100 h-100 d-flex flex-column justify-content-center align-items-center">
            <h1 class="text-white display-4">Todo App</h1>
            <todo-component></todo-component>
        </div>
    </div>
@endsection
