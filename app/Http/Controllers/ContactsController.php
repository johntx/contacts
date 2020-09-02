<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contacts;
use Illuminate\Routing\Route;
use Validator;
use Auth;

class ContactsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only' => ['index','create','edit','show']]);
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show']]);
    }
    public function find(Route $route)
    {
        $this->contact = Contacts::find($route->getParameter('contact'));
        $this->user = User::find($route->getParameter('contact'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contacts::paginate(10);
        return view('admin/contact.index',compact('contacts'),['me'=>'MEMP','po'=>'EMP']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $biometrics = \Institute\Biometric::orderBy('nombre','asc')->lists('nombre', 'id');
        $roles = \Institute\Role::where('roles.code','!=','ROOT')
        ->where('roles.code','!=','ADM')
        ->where('roles.code','!=','EST')
        ->where('roles.code','!=','DOC')
        ->lists('name', 'id');
        $offices = \Institute\Office::lists('nombre', 'id');
        return view('admin/contact.create',['biometrics'=>$biometrics, 'roles'=>$roles, 'offices'=>$offices,'me'=>'MEMP','po'=>'CEMP']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['nombre']=strtoupper($request['nombre']);
        $request['paterno']=strtoupper($request['paterno']);
        $validator = Validator::make($request->all(), [
            'user' => 'required|unique:users',
            ]);
        if ($validator->fails()) {
            return redirect('/admin/contact/create')
            ->withErrors($validator)
            ->withInput();
        }
        $user = new User;
        $user->fill([
            'user' => $request['user'],
            'password' => $request['password'],
            'role_id' => $request['role_id']
            ]);
        $people = new Contacts;
        $people->fill([
            'id' => $user->id,
            'ci' => $request['ci'],
            'nombre' => $request['nombre'],
            'paterno' => $request['paterno'],
            'fecha_ingreso' => \Carbon\Carbon::now(),
            'fecha_nacimiento' => $request['fecha_nacimiento'],
            'direccion' => $request['direccion'],
            'telefono' => $request['telefono'],
            'office_id' => $request['office_id']
            ]);
        //return $user;
        $user->save();
        $user->people()->save($people);
        Session::flash('success','Empleado registrado exitosamente');
        return Redirect::to('/admin/contact');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin/contact.delete',['contact'=>$this->contact,'me'=>'MEMP','po'=>'EMP']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $biometrics = \Institute\Biometric::orderBy('nombre','asc')->get();
        $roles = \Institute\Role::where('roles.code','!=','ROOT')
        ->where('roles.code','!=','EST')
        ->where('roles.code','!=','DOC')
        ->lists('name', 'id');
        $offices = \Institute\Office::lists('nombre', 'id');
        return view('admin/contact.edit',['biometrics'=>$biometrics, 'contact'=>$this->contact, 'roles'=>$roles, 'offices'=>$offices,'me'=>'MEMP','po'=>'EMP']);
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
        $request['nombre']=strtoupper($request['nombre']);
        $request['paterno']=strtoupper($request['paterno']);
        $validator = Validator::make($request->all(), [
            'user' => 'required|unique:users,user,'.$id.',id'
        ]);
        if ($validator->fails()) {
            return redirect('/admin/contact/'.$id.'/edit')
                ->withErrors($validator)
                ->withInput();
        }
        $this->user->fill($request->all());
        $this->contact->fill($request->all());
        $this->user->save();
        $this->contact->save();
        Session::flash('success','Empleado editado exitosamente');
        return Redirect::to('/admin/contact');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->contact->delete();
        Session::flash('success','Empleado borrado exitosamente');
        return Redirect::to('/admin/contact');
    }
}
