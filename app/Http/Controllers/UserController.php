<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth',['only' => ['index','create','edit','update','show']]);
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show']]);
    }
    public function find(Route $route)
    {
        $this->user = User::find($route->getParameter('user'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('role_id','desc')->orderBy('id','DESC')->get();
        return view('user.index',compact('users'),['me'=>'MUSR','po'=>'USR']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('user.create',['offices'=>$offices,'roles'=>$roles,'me'=>'MUSR','po'=>'CUSR','horas'=>$horas,'dias'=>$dias,'cities'=>$cities]);
    }

    public function changePassword(Request $request)
    {
        if (Auth::user()) {
            if (Hash::check($request['passwordold'], Auth::user()->password) && $request['password'] == $request['password_confirmation']) {
                $user = Auth::user();
                $user->password = $request['password'];
                $user->save();
                Session::flash('success','Contraseña camniada exitosamente');
                return redirect()->to('admin');
            } else {
                return redirect('pass/changePasswordForm')
                ->withErrors('Contraseña Incorrecta')
                ->withInput();
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'user' => 'required|unique:users',
        ]);
        if ($validator->fails()) {
            return redirect('user/create')
            ->withErrors($validator)
            ->withInput();
        }

        $user = new User;
        $user->fill([
            'user' => $request['user'],
            'password' => $request['password'],
            'remember_token' => md5($token)
        ]);
        return Redirect::to('/user');
          
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $roles = \App\Role::where('code','!=','ROOT')->lists('name', 'id');
        return view('user.delete',['user'=>$this->user, 'roles'=>$roles,'me'=>'MUSR','po'=>'USR']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $this->user->nombre = $this->user->people->nombre;
        $this->user->telefono = $this->user->people->telefono;
        $this->user->fecha_ingreso = $this->user->people->fecha_ingreso;

        return view('user.edit',['offices'=>$offices,'user'=>$this->user, 'roles'=>$roles,'me'=>'MUSR','po'=>'USR','horas'=>$horas,'dias'=>$dias,'cities'=>$cities]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'user' => 'required|unique:users,user,'.$id.',id'
        ]);
        if ($validator->fails()) {
            return redirect('/user/'.$id.'/edit')
            ->withErrors($validator)
            ->withInput();
        }
        $this->user->fill([
            'user' => $request['user'],
            'password' => $request['password']
        ]);
        $this->user->save();
        $people = $this->user->people;
        $people->fill([
            'nombre' => $request['nombre'],
            'telefono' => $request['telefono'],
            'color' => $request['color'],
            'codigo' => $request['codigo'],
            'fecha_ingreso' => $request['fecha_ingreso'],
            'city_id' => $request['city_id'],
            'orden' => $request['orden'],
            'office_id' => $request['office_id'],
            'no_trabajo' => $request['no_trabajo']
        ]);
        $people->save();
        Session::flash('success','Usuario editado exitosamente');
        return Redirect::to('/user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->user->client !=null) {
            $this->user->client->delete();
        }
        if ($this->user->employee !=null) {
            $this->user->employee->delete();
        }
        $this->user->delete();
        Session::flash('success','Usuario borrado exitosamente');
        return Redirect::to('/user');
    }
}
