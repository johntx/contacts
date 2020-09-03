<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="{!!URL::to('icons/logomin.png')!!}" />
  <link rel="icon" type="image/png" href="{!!URL::to('icons/logomin.png')!!}" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>Contacts List System</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  {!!Html::style('css/materialdesignicons.min.css')!!}
  {!!Html::style('css/boot.css')!!}
  {!!Html::style('css/admin.css')!!}
  {!!Html::style('css/MentisMe.css')!!}
  @yield('admincss')
</head>
<?php if(!isset($me)){$me='';} if(!isset($po)){$po='';} ?>
<body>
  <div id="cortina" onclick="ocultar_cortina();"></div>
  @include('alerts.success')
  @include('alerts.alert')
  @include('alerts.error')
  <aside>
    <div class="logo">
      <a href="{{url::to('admin')}}">
        <p id="txt_logo_menu">Contacts List System</p>&nbsp;&nbsp;&nbsp;
      </a>
    </div>
    <div class="sidebar">
      <ul>
        <li class="nav_menu @if($me == 'MCN'){{'active'}}@endif" href="#">
          <a href="#" onclick="return false;">
            <i class="mdi mdi-icon"></i><p>Contacts</p>
          </a>
          <ul tamano="60">
            <li>
              <a class="@if($po == 'CNC'){{'estoy'}}@endif" href="{{url('/admin/contacts/create')}}"><i class="mdi mdi-menu-right"></i><p>Register Contact</p></a>
            </li>
            <li>
              <a class="@if($po == 'CNV'){{'estoy'}}@endif" href="{{url('/admin/contacts')}}"><i class="mdi mdi-menu-right"></i><p>View Contacts</p></a>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </aside>
  <section>
    <nav>
      <div class="nav-menu-btn">
        <a onclick="mostrar_aside();">
          <i class="mdi mdi-menu"></i>
        </a>
      </div>
      <div class="nav-search">
        <input type="text" value="" id="input_buscador" onclick="buscar(this);" class="form-control buscador" placeholder="Search..">
        <button type="button" onclick="buscar(this);">
          <i class="mdi mdi-magnify"></i>
        </button>
        <ul id="ul_est">
          @foreach (\App\Contacts::orderBy('id','DESC')->get() as $contact)
          <li>
            <a href="{!!url('admin/contact/search/'.$contact->id)!!}" class="ver_est">&nbsp;&nbsp;&nbsp; {{$contact->fullname()}} - [{{$contact->contact_number}}] - ({{$contact->email}})</a>
            <a href="{!!url('admin/contact/'.$contact->id.'/edit')!!}" class="edit_est">
              <i class="mdi mdi-pencil"></i>
            </a>
          </li>
          @endforeach
        </ul>
      </div>
      <div class="nav-log">
        <a onclick="desplegar_log(this);">
          <i class="mdi mdi-account"></i>
        </a>
        <ul>
          <li><a href="{!!URL::to('user/'.Auth::id().'/edit')!!}"><i class="mdi mdi-pencil"></i>Edit profile</a></li>
          <li><a href="{!!URL::to('pass/changePasswordForm')!!}"><i class="mdi mdi-key"></i>Change password</a></li>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
          </form>
          <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="mdi mdi-logout"></i>Log out</a>
          </li>
        </ul>
      </div>
      <div class="nav-user"><p>{{Auth::user()->name}}</p><p>{{Auth::user()->email}}</p></div>
    </nav>
    <div class="content">
      @yield('content')
    </div>
  </section>
  {!!Html::script('js/jquery.js')!!}
  {!!Html::script('js/jquery-ui.min.js')!!}
  {!!Html::script('js/boot.js')!!}
  {!!Html::script('js/admin.js')!!}
  @yield('adminjs')
  @yield('adminjs2')
</body>
</html>
