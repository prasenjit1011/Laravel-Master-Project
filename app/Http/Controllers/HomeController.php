<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\TodoAlert;
use App\Jobs\TodoJob;
use App\Models\Todo;
use App\Traits\TodoTrait;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

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

        if (!Gate::allows('update-todo', $todo)) {
            abort(403);
        }

        return view('todos.addedit', compact('id', 'todo'));
    }

    public function update(Request $request, Todo $todo, $id){
        dd(1452445);
        if (! Gate::allows('update-post', $todo)) {
            abort(403);
        }
        dd(44556677);


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
        // HTTP-Client-Get
        $arr        = ['name' => 'Taylor', 'page' => 1 ];
        $url        = 'https://quotes-api.tickertape.in/quotes?sids=IRM,DABU';
        $response1  = Http::timeout(3)->get($url);
        //$response = Http::post($url, $arr);
        
        $url        = 'http://localhost:8010/api/get_user';
        $token      = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTcwMTQ0MDcxMywiZXhwIjoxNzAxNDQ0MzEzLCJuYmYiOjE3MDE0NDA3MTMsImp0aSI6IlBFY2JGVmNKMlZUWTN2VXAiLCJzdWIiOjIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.0pPgAA9PED8HP2uLf3GV6lnAQIv5Dm0gTiZIJM4A-Q0';
        $response2  = Http::acceptJson()->withToken($token)->timeout(3)->get($url, $arr);
        //$response = Http::timeout(3)->get($url);

        $array = Arr::collapse([[1, 2, 3], [4, 5, 6], [7, 8, 9]]);
        info('Some helpful information!');

        dd('-: Note Data :-', $response1->json(), $response2->json(), json_encode($array));
    }
}
