<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Routing\Route;
use App\Contacts;
use App\Mail\TestMail;
use Mail;

class ContactsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $contacts = Contacts::paginate(10);
        return view('admin\contacts\index',compact('contacts'),['me'=>'MCN','po'=>'CNV']);
    }

    public function create()
    {
        return view('admin\contacts\create',['me'=>'MCN','po'=>'CNC']);
    }

    public function store(Request $request)
    {
        Contacts::insert(request()->except('_token'));
        Mail::to($request['email'])->send(new TestMail($request,'msg_welcome'));
        Session::flash('success','Contact successfully registered!');
        return redirect('/admin/contacts');
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $contact = Contacts::findOrFail($id);
        return view('admin\contacts\edit',compact('contact'),['me'=>'MCN']);
    }

    public function update(Request $request, $id)
    {
        $data = request()->except(['_token','_method']);
        Contacts::where('id',$id)->update($data);
        Session::flash('success','Contact successfully edited!');
        return redirect('/admin/contacts');
    }

    public function destroy($id)
    {
        Contacts::destroy($id);
        Session::flash('success','Contact successfully removed!');
        return redirect('/admin/contacts');
    }
}
