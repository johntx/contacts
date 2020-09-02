<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="{!!URL::to('icons/logomin.png')!!}" />
  <link rel="icon" type="image/png" href="{!!URL::to('icons/logomin.png')!!}" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>{{isset($me)?\casas\Menu::where("code",$me)->first()->label:'Inmo Cabezas'}}</title>
  <!--meta name="viewport" content="width=device-width, initial-scale=1"-->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  {!!Html::style('css/materialdesignicons.min.css')!!}
  {!!Html::style('css/boot.css')!!}
  {!!Html::style('css/admin.css')!!}
  {!!Html::style('css/jquery-ui.min.css')!!}
  {!!Html::style('css/MentisMe.css')!!}
  @yield('admincssmap')
  @yield('admincss')
</head>
<?php
if(!isset($me)){$me='';} if(!isset($po)){$po='';}
?>
<body>
  <div id="cortina" onclick="ocultar_cortina();"></div>
  @include('alerts.success')
  @include('alerts.alert')
  @include('alerts.error')
  @include('modal.confirmacion')
  @include('modal.notes')
  <aside>
    <div class="logo">
      <a href="{{url::to('admin')}}">
        @if (Auth::user()->people->city->country->nombre=='Bolivia')
        <img alt="DEV" src="{!!URL::to('img/logo_full.png')!!}" height="18px">&nbsp;<p id="txt_logo_menu"></p>&nbsp;&nbsp;&nbsp;
        @else
        <img alt="DEV" src="{!!URL::to('img/logo_full.png')!!}" height="18px">&nbsp;&nbsp;&nbsp;&nbsp;<img alt="DEV" src="{!!URL::to('img/valac.jpg')!!}" height="18px">
        @endif
      </a>
    </div>
    <div class="sidebar">
      <ul>
        @foreach(Auth::user()->mi_menu() as $menu)
        <li class="nav_menu @if($me == $menu->code){{'active actual'}}@endif" href="{{URL::to($menu->path)}}">
          <a href="#" onclick="return false;">
            <i class="mdi mdi-{{$menu->icon}}"></i><p>{{$menu->label}}</p>
          </a>
          <?php $functionalities = Auth::user()->mi_functions($menu->id); 
          $lis = count($functionalities);
          $cities = \casas\City::get();
          if ($menu->code=="MAVE") { $lis += count($cities); }
          $height = ($lis*30)+(($lis-1)*10);
          ?>
          <ul tamano="{{$height}}">
            @foreach($functionalities as $functionality)
            <li>
              <?php $uri=$_SERVER["REQUEST_URI"];$tamano=strlen($_SERVER["REQUEST_URI"]); ?>
              <a class="@if($po == $functionality->code){{'estoy'}}@endif" href="{{URL::to($functionality->path)}}"><i class="mdi mdi-menu-right"></i><p>{{ $functionality->label }}</p></a>
            </li>
            @endforeach
            {{--si es avenidas mostrar las ciudades y sus avenidas--}}
            @if ($menu->code=="MAVE")
            @foreach($cities as $city)
            <li>
              <a class="@if($po == "AVE-".$city->codigo){{'estoy'}}@endif" href="{{URL::to('admin/avenida/city/'.$city->codigo)}}"><i class="mdi mdi-menu-right"></i><p>{{ $city->nombre }}</p></a>
            </li>
            @endforeach
            @endif
          </ul>
        </li>
        @endforeach
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
      @if (Auth::user()->hasRole('EXT') || Auth::user()->hasRole('GA'))
      <div class="nav-search"></div>
      @else
      <div class="nav-search">
        <input type="text" value="" id="input_buscador" onclick="buscar(this);" class="form-control buscador" placeholder="Buscar..">
        <button type="button" onclick="buscar(this);">
          <i class="mdi mdi-magnify"></i>
        </button>
        <ul id="ul_est"></ul>
      </div>
      @endif
      <div class="nav-log">
        <a onclick="desplegar_log(this);">
          <i class="mdi mdi-account"></i>
        </a>
        <ul>
          <li><a href="{!!URL::to('logout')!!}"><i class="mdi mdi-logout"></i>Cerrar Sesion</a></li>
          <li><a href="{!!URL::to('pass/changePasswordForm')!!}"><i class="mdi mdi-key"></i>Cambiar Contraseña</a></li>
        </ul>
      </div>
      <div class="nav-user"><p>{{Auth::user()->user}}</p>
        <p>
          @foreach (Auth::user()->roles as $role)
          [{{$role->name}}]
          @endforeach
        </p>
      </div>
    </nav>
    <div class="content">
      @yield('content')
    </div>
  </section>
  {!!Html::script('js/jquery.js')!!}
  {!!Html::script('js/jquery-ui.min.js')!!}
  {!!Html::script('js/datatables.js')!!}
  {!!Html::script('js/boot.js')!!}
  {!!Html::script('js/admin.js')!!}
  @yield('adminjsmap')
  @yield('adminjs')
  @yield('adminjs2')
</body>
</html>
