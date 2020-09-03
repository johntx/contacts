<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\UserCreateRequest;
use Illuminate\Routing\Route;
use App\User;
use Auth;
use Hash;
use Validator;
use App\Mail\TestMail;
use Mail;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',['only' => ['index','edit','show','destroy','changePasswordForm']]);
    }

    public function index()
    {
        $users = User::paginate(10);
        return view('user\index',compact('users'),['me'=>'MUS','po'=>'CNV']);
    }

    public function create()
    {
        return view('user\create',['me'=>'MUS','po'=>'CNC']);
    }

    public function store(Request $request)
    {
        if ($request['password'] == $request['password_confirmation']) {
            $user = New User;
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->password = bcrypt($request['password']);
            $user->save();
            Mail::to($user['email'])->send(new TestMail($user,'msg_welcome_user'));
            Auth::attempt(['name'=>$request['name'],'password'=>$request['password']]);
            Session::flash('success','Welcome to Contacts List System');
            return Redirect::to('admin/contacts');
        } else {
            Session::flash('error','Incorrect data');
            return redirect('pass/user/create');
        }
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user\edit',compact('user'),['me'=>'MUS']);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:users,name,'.$id.',id'
        ]);
        if ($validator->fails()) {
            return redirect('/user/'.$id.'/edit')
            ->withErrors($validator)
            ->withInput();
        }
        $data = request()->except(['_token','_method']);
        User::where('id',$id)->update($data);
        Session::flash('success','Contact successfully edited!');
        return redirect('/admin');
    }

    public function destroy($id)
    {
        User::destroy($id);
        Session::flash('success','Contact successfully removed!');
        return redirect('/admin');
    }

    public function changePassword(Request $request)
    {
        if (Auth::user()) {
            if (Hash::check($request['passwordold'], Auth::user()->password) && $request['password'] == $request['password_confirmation']) {
                $user = Auth::user();
                $user->password = bcrypt($request['password']);
                $user->save();
                Session::flash('success','Password changed successfully');
                return redirect()->to('admin');
            } else {
                Session::flash('error','Incorrect data');
                return redirect('pass/changePasswordForm');
            }
        } else {
            return redirect()->to('/');
        }

        Session::flash('success','Usuario registrado exitosamente');
        return redirect('admin')
        ->withErrors('Contraseña Cambiada Correctamente')
        ->withInput();
    }

    public function changePasswordForm(Request $request)
    {
        if (Auth::user()) {
            return view('auth.changePassword');
        } else {
            return redirect()->to('/');
        }
    }
}
