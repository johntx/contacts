<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use Redirect;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = \App\User::where('name', $request['name'])->first();

        if ($user!=null) {
            if (Auth::attempt(['name'=>$request['name'],'password'=>$request['password']])) {
                Session::flash('success','Bienvenido! :D');
                return Redirect::to('admin/contacts');
            }else{
                Session::flash('error','Contraseña incorrecta!.');
                return Redirect::to('log');
            }

        }
        Session::flash('error','Este usuario no existe.');
        return Redirect::to('log');
    }

    public function logout()
    {
        Auth::user()->people->telefono2 = 'NO';
        Auth::user()->people->save();
        Auth::logout();
        Session::flush();
        \Cache::flush();
        Session::flash('success','Hasta pronto.');
        return Redirect::to('log');
    }
    public function confirmAccount($token)
    {
        $user = \App\User::where('remember_token', md5($token))->first();
        if ($user!=null) {
            $role = \App\Role::where('code', 'EXT')->first();
            $user->role_id = $role->id;
            $user->remember_token = md5(microtime());
            $user->save();
            return view('layouts.confirmationok');
        }        
        return view('layouts.confirmationerror');
    }
}
