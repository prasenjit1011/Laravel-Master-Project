@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Todo List') }}
                    <button class="btn btn-primary btn-sm" style="float:right" onclick="window.location.href='{{ route('todo.create')}}'">Add</button>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                    @if(session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                
                    <table width="100%" style="border: 1px solid #000 !important;">
                        <thead>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Details</th>
                            <th width="150">Action</th>
                        </thead>
                        <tbody>
                            @foreach($todos as $todo)
                                <tr>
                                    <td>{{ $todo->name}}</td>
                                    <td>{{ $todo->status == 1 ? 'Active' : 'Completed'}}</td>
                                    <td>{{ $todo->details}}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" style="float:left; margin-right:10px;" onclick="window.location.href='{{ route('todo.edit', $todo->id )}}'">Edit</button>
                                        <form  action="{{ route('todo.destroy', ['todo' => $todo->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm btn-block">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
