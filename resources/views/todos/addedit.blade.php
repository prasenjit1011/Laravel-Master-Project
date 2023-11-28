@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Todo Details') }}</div>
                <div class="card-body">
                
                    <form id="todoFrm" action="{{ !empty($todo->id) ? route('todo.update', $todo->id) : route('todo.store') }}" method="post" >
                        @csrf
                        @method(!empty($todo->id) ? 'PUT' : 'POST')
                        <div class="form-group" style="margin:20px 0;">
                            <label>Name</label>
                            <input type="text" required class="form-control" name="name" id="name" aria-describedby="emailHelp" placeholder="Enter Todo Name"  value="{{ $todo->name ?? '' }}" />
                            
                            @if($errors->any())
                                <span class="alert" role="alert" style="color: brown;;">
                                    <strong>{{$errors->first()}}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group " style="margin:20px 0;" >
                            <label style="float:left; width:175px;">Status</label>
                            <div class="form-check" style="float:left; width:175px;">
                                <input class="form-check-input" type="radio" name="status" id="status2" value="1" {{ empty($todo) || $todo->status == 1 ? 'checked':''}}>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Active
                                </label>
                            </div>
                            <div class="form-check" style="float:left; width:175px;">
                                <input class="form-check-input" type="radio" name="status" id="status2" value="2" {{ !empty($todo->status) && $todo->status == 2 ? 'checked':''}}>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Completed
                                </label>
                            </div>
                        </div>
                        <br />
                        
                        
                        <div class="form-group" style="margin:20px 0;">
                            <label>Details</label>
                            <textarea  class="form-control" name="details">{{ $todo->details ?? '' }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" onclick="">{{ __('Submit') }}</button>
                        <button type="button" class="btn btn-outline-secondary" onclick="window.location.href='{{ route('todo.index')}}'">{{ __('Cancel') }}</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
