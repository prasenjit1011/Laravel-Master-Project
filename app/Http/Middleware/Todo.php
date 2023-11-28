<?php
 
namespace App\Http\Middleware;
 
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
 
class Todo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (request()->getMethod() != 'GET')
        {
            $fields = [
                'name' => 'required',
            ];
            $validator = Validator::make($request->all(), $fields);
        
            if ($validator->fails()) {
                //dd(45, $request->all());
                return redirect()->back()->withInput($request->all())->withErrors($validator);
            }
        }
        

        return $next($request);
    }
}