@extends('layouts.admin')
@section('content')
<?php $editar=false; $eliminar=false;
foreach (Auth::user()->all_functions() as $func) {
	if ($func->code=='EUSR'){ $editar=true; }
	if ($func->code=='DUSR'){ $eliminar=true; }
}
?>
<div class="card">
	<div class="card-header primary-low">
		<h5 class="card-title">Usuarios</h5>
	</div>
	<div class="card-body">
		<div class="flotantes">
			<div class="flex ">
				<div class="btn nl info" onclick="seleccionar('table-responsive')">Seleccionar todo</div>				
			</div>
			<div id="filtro">
				<input type="search" placeholder="Filtro:">
			</div>
		</div>
		<div class="table-responsive">
			<table class="table">
				<thead>
					<th>Id</th>
					<th><b>Usuario</b></th>
					<th><b>Rol</b></th>
					<th>Nombre Completo</th>
					<th># Inspecciones</th>
					<th>Oficina</th>
					<th>Código</th>
					<th>Ciudad</th>
					<th>Orden</th>
					<th>Color</th>
					<th>Editar</th>
				</thead>
				<tbody>
					@foreach($users as $user)
					<tr>
						<td>{{$user->id}}</td>
						<td><b>{{$user->user}}</b></td>
						<td>@foreach ($user->roles as $role)
							[{{$role->name}}]
						@endforeach</td>
						<td>{{$user->people->nombre}}</td>
						<td class="centrado">{{($user->people->no_trabajo>0)?$user->people->no_trabajo:''}}</td>
						<td>{{$user->people->office["nombre"]}}</td>
						<td class="centrado">{{$user->people->codigo}}</td>
						<td>{{$user->people->city->nombre}}</td>
						<td class="centrado">{{$user->people->orden}}</td>
						<td class="centrado" style="background-color:{{$user->people->color}};"><b>COLOR</b></td>
						@if ($editar)
						<td>
							{!!link_to_route('user.edit', $title = 'Edit', $parameters = $user->id, $attributes = ['class'=>'btn primary'])!!}
						</td>
						@endif
						@if ($eliminar)
						<td>
							{!!link_to_route('user.show', $title = 'Delete', $parameters = $user->id, $attributes = ['class'=>'btn danger'])!!}
						</td>
						@endif
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection