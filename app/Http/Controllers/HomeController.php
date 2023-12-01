<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\TodoAlert;
use App\Jobs\TodoJob;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Traits\TodoTrait;
use Illuminate\Support\Arr;

class HomeController extends Controller
{
    use TodoTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        TodoAlert::dispatch('NodeJS');;
        dispatch(new TodoJob('ReactJS'))->delay(20);

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $todos = Todo::where('user_id', Auth::user()->id)->get();
        return view('todos.index', compact('todos'));
    }

    public function create(){
        return view('todos.addedit');
    }

    public function store(Request $request){
        $data = array_merge($request->all(), ['user_id' => Auth::user()->id]);
        $data['image'] = $this->verifyAndUpload($request, 'image', 'images');

        Todo::create($data);
        return redirect(route('todo.index'))->with('success', 'Todo added successfully.');
    }

    public function edit($id){
        $todo = Todo::find($id);
        return view('todos.addedit', compact('id', 'todo'));
    }

    public function update(Request $request, $id){
        $todo = Todo::find($id);
        $data   = $request->all();
        $data['image'] = $this->verifyAndUpload($request, 'image', 'images');
        
        if($todo){
            $todo->update($data);
        }
        return redirect(route('todo.index'))->with('success', 'Todo updated successfully.');;
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return redirect(route('todo.index'))->with('success', 'Todo deleted successfully.');;
    }

    public function show(Request $request){
        return redirect(route('todo.index'));
    }

    public function todoScheduler(){
        Log::alert('Todo Controller called from scheduler command.');
    }

    static function todoStaticScheduler(){
        Log::alert('Todo Controller Static Function called from scheduler command.');
    }

    public function notes(){
        $array = Arr::collapse([[1, 2, 3], [4, 5, 6], [7, 8, 9]]);
        info('Some helpful information!');
        dd($array);
    }
}
