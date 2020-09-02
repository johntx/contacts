<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
	public function index() {
		return Redirect::to('log');
		return view('log');
	}
	public function admin() {
		return view('admin/contacts');
	}
}
