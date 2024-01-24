<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Models\Product;
use App\Models\Todo;
use GuzzleHttp\Promise\Create;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/data', function(){
    return response()->json([
        'id'    => 1,
        'data'  => rand(10, 99)
    ]);
});
Route::post('login', [ApiController::class, 'authenticate']);
Route::post('register', [ApiController::class, 'register']);
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('logout', [ApiController::class, 'logout']);
    Route::get('get_user', [ApiController::class, 'get_user']);
});

Route::get('product/list', function(Request $request){
    $todos = Product::select('product_name as name', 'product_description as details')->get()->toArray();
    return json_encode(['status'=>true, 'msg'=>'Listing Data', 'data'=>$todos]);
});

Route::get('todo/list', function(Request $request){
    $todos = Todo::where('user_id', 1)->get()->toArray();
    return json_encode(['status'=>true, 'msg'=>'Listing Data', 'data'=>$todos]);
});

Route::post('todo/add', function(Request $request){
    $data = array_merge($request->all(), ['user_id' => 1]);
    Todo::create($data);
    return json_encode(['status'=>true, 'msg'=>'Added successfully!', 'data'=>$data]);
});