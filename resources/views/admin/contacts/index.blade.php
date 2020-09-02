@extends('layouts.admin')
@section('content')
<?php $crear=false; $editar=false; $eliminar=false;
foreach (Auth::user()->all_functions() as $func) {
	if ($func->code=='COFF'){ $crear=true; }
	if ($func->code=='EOFF'){ $editar=true; }
	if ($func->code=='DOFF'){ $eliminar=true; }
}
?>
<div class="card">
	<div class="card-header primary-low">
		<h5 class="card-title">Oficiales de Créditos</h5>
	</div>
	<div class="card-body">
		@if ($crear)
		{!!link_to_route('admin.official.create', $title = 'Registrar Official',$attributes = [], $attributes = ['class'=>'btn primary'])!!}
		@endif
		<div class="table-responsive">
			<table class="table tablaNoOrder compact">
				<thead>
					<th>Nombre</th>
					<th>Cargo</th>
					<th>Interno</th>
					<th>Teléfono</th>
					<th>Correo</th>
					<th>Agencia</th>
					<th>Banco</th>
					@if ($editar)<th>Edit</th>@endif
					@if ($eliminar)<th>Delete</th>@endif
				</thead>
				<tbody>
					@foreach($officials as $official)
					<tr>
						<td>{{$official->nombre}}</td>
						<td>{{$official->cargo}}</td>
						<td>{{$official->interno}}</td>
						<td>{{$official->telefono}}</td>
						<td>{{$official->correo}}</td>
						<td><b>{{$official->agency->nombre}}</b></td>
						<td><b style="color:{{$official->agency->bank->color}};">{{$official->agency->bank->nombre}}</b></td>
						@if ($editar)
						<td>
							{!!link_to_route('admin.official.edit', $title = 'Editar', $parameters = $official->id, $attributes = ['class'=>'btn primary'])!!}
						</td>
						@endif
						@if ($eliminar)
						<td>
							{!!link_to_route('admin.official.show', $title = 'Borrar', $parameters = $official->id, $attributes = ['class'=>'btn danger'])!!}
						</td>
						@endif
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
{!!$officials->render()!!}
@endsection