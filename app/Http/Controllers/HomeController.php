<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;

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
        $todos = Todo::where('user_id', Auth::user()->id)->get();
        //dd($todos);
        return view('home', compact('todos'));
    }

    public function create(){
        return view('todos.addedit');
    }

    public function store(Request $request){
        $data = array_merge($request->all(), ['user_id' => Auth::user()->id]);
        //dd($data);
        Todo::create($data);
        return redirect(route('todo.index'))->with('success', 'Todo added successfully.');
    }

    public function edit($id){
        $todo = Todo::find($id);
        return view('todos.addedit', compact('id', 'todo'));
    }

    public function update(Request $request, $id){
        //dd('Update', $id, $request->all());

        $todo = Todo::find($id);
        $data   = $request->all();
        
        if($todo){
            $todo->update($data);
        }

        return redirect(route('todo.index'))->with('success', 'Todo updated successfully.');;
    }

    public function show(Request $request){
        //dd('Show', $request->all());
        return redirect(route('todo.index'));
    }
}
