@extends('layouts.admin')
@section('content')
@include('modal.maps')
@include('modal.files')
<?php
$peoples->each(function ($people)
{
	$people->avaluos = count($people->avaluos_inspector_hoy);
});
?>
@foreach($peoples->sortByDesc('avaluos') as $people)
<div class="card">
	<div class="card-header primary-soft">
		<h5 class="card-title" style="color: black;"><b>Inspector de Gabinete : {{$people->codigo}}</b></h5><span>id: {{$people->id}}</span>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table min">
				<thead>
					<th>Nº</th>
					<th>Avaluo</th>
					<th>Fecha Cita</th>
					<th>Cliente</th>
					<th class="centrado">Tipo</th>
					<th class="centrado">Fecha Inicio de Trabajo</th>
					<th class="centrado">Codigo</th>
					<th class="centrado">IC</th>
					<th>Estado</th>
					<th class="centrado">Fotos</th>
					<th class="centrado">Hoja Excel</th>
					<th class="centrado">Notas</th>
				</thead>
				<tbody>
					<?php $avaluos = $people->avaluos_gab->sortBy('fecha_inicio_gabinete'); $key=0; ?>
					@foreach ($avaluos as $avaluo)
					<tr>
						<td>{{++$key}}</td>
						<td>{{$avaluo->id}}</td>
						<td>{{Carbon\Carbon::parse($avaluo->fecha_cita)->format('d/m/Y')}}</td>
						<td><b>{{$avaluo->client_nombre()}}</b></td>
						<td class="centrado"><b>{{$avaluo->type->codigo}}</b></td>
						<td class="centrado"><b>{{isset($avaluo->fecha_inicio_gabinete)?Carbon\Carbon::parse($avaluo->fecha_inicio_gabinete)->format('d/m/Y (H:i)'):''}}</b></td>
						<th class="centrado">{{$avaluo->codigo}}</th>
						<td class="centrado"><b>{{$avaluo->inspector->codigo}}</b></td>
						<td>{{$avaluo->estado}}{!!$avaluo->sinDocumentos()!!}{!!$avaluo->prioridad()!!}</td>
						<td class="centrado">
							<button type="button" class="subir btn success" avaluo_id="{{$avaluo->id}}">Fotos</button>
						</td>
						<td class="centrado">
							{!!link_to_action('IDGController@excel', $title = 'Excel', $parameters = $avaluo->id, $attributes = ['class'=>'btn primary'])!!}
						</td>
						<td class="centrado">
							<div class="button_contenedor"><button class="btn btn-circle info btn_notas" avaluo_id="{{$avaluo->id}}">{!!count($avaluo->notes)>0?"<i>".count($avaluo->notes)."</i>":''!!}💬</button></div>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endforeach
@endsection
@section('adminjs')
<script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"></script>
{!!Html::script('js/maps.js')!!}
@endsection
@section('admincss')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" />
@endsection
