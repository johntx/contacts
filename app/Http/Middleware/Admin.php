<?php

namespace casas\Http\Middleware;
use Illuminate\Contracts\Auth\Guard;
use Closure;
use Session;
use Auth;

class Admin
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::user()) {
            return redirect()->to('log');
        }
        $functionalities = collect();
        foreach (Auth::user()->roles as $role) {
            $functionalities->push($role->functionalities);
        }
        if (count($functionalities)>0){
            if ($request->path()=='admin'){
                return $next($request);
            } else {
                $path = $request->path();
                $path_ori = $request->path();
                $id = intval(preg_replace('/[^0-9]+/', '', $request->path()), 10);
                if (substr($request->path(), strlen($request->path())-4, strlen($request->path()))=='edit') {
                    $path = str_replace($id.'/edit', "edit", $path);
                }
                if (substr($request->path(), strlen($request->path())-strlen($id), strlen($request->path()))==$id) {
                    $path = str_replace($id, "show", $path);
                }
                if (substr($request->path(), strlen($request->path())-strlen($id), strlen($request->path()))==$id) {
                    $path = str_replace($id, "delete", $path);
                }

                Session::flash('error','Usuario sin Privilegios:('.$path.')');
                return redirect()->to('admin');
            }
        } else {
            Session::flash('error','Usuario sin ningun Privilegio');
            Auth::logout();
            return redirect()->to('/');
        }
    }
}
