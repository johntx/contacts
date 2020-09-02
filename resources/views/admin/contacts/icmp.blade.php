@extends('layouts.admin')
@section('content')
@include('modal.maps')
@include('modal.files')
<?php 
$crearobs=false; 
foreach (Auth::user()->all_functions() as $func) {
	if ($func->code=='COBS'){ $crearobs=true; }
}
$peoples->each(function ($people)
{
	$people->avaluos = count($people->avaluos_inspector_hoy);
});
?>
@if ($crearobs)
<div class="card borde_coral">
	<div class="card-header color_coral ">
		<h5 class="card-title">Observaciones</h5>
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
					<th class="centrado">Observacion</th>
					<th class="centrado">Fecha cita</th>
					<th class="centrado">Cliente</th>
					<th class="centrado">Banco</th>
					<!--<th class="centrado">IC</th>-->
					<th class="centrado">IG</th>
					<th class="centrado">Estado</th>
					<th class="centrado">Responsable</th>
					<th class="centrado">Tiempo Trabajo</th>
					<th class="centrado">Obs</th>
					<th class="centrado">Notas</th>
				</thead>
				<tbody>
					@foreach($observados as $avaluoobs)
					<tr>
						<td>{{$avaluoobs->observacion_id}}</td>
						<td class="centrado"><b>{{Carbon\Carbon::parse($avaluoobs->fecha_obs)->format('d/m/Y')}}</b></td>
						<td class="centrado"><b>{{Carbon\Carbon::parse($avaluoobs->fecha_cita)->format('d/m/Y')}}</b></td>
						<td>{{$avaluoobs->client_nombre()}}</td>
						<td>{{$avaluoobs->bank->nombre}}</td>
						<!--<td class="centrado"><b>{{$avaluoobs->inspector->codigo}}</b></td>-->
						<td class="centrado"><b>{{$avaluoobs->gabinete->codigo}}</b></td>
						<td class="centrado"><i><b>INSPECCION</b></i></td>
						<td class="centrado"><b>{{$avaluoobs->people_nombre}}</b></td>
						<td class="centrado"><b>{{Jenssegers\Date\Date::parse(Carbon\Carbon::now())->diffForHumans($avaluoobs->fecha_fase)}}</b></td>
						<td class="centrado">
							{!!link_to_action('ObservacionesController@obs', $title = 'Obs', $parameters = $avaluoobs->avaluo_id, $attributes = ['class'=>'btn danger'])!!}
						</td>
						<td class="centrado">
							<div class="button_contenedor"><button class="btn btn-circle info btn_notas" avaluo_id="{{$avaluoobs->avaluo_id}}">{!!count($avaluoobs->notes)>0?"<i>".count($avaluoobs->notes)."</i>":''!!}💬</button></div>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endif
@foreach($peoples->sortByDesc('avaluos') as $people)
<div class="card">
	<div class="card-header " style="background-color:{{$people->color}} ;">
		<h5 class="card-title" style="color: #060606"><b>Inspector de Campo : {{$people->codigo}}</b> </h5><b>{{$people->nombre}}</b><span>id: {{$people->id}}</span>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table">
				<thead>
					@if (Auth::user()->people->city->country->nombre=='Bolivia')
					<th class="centrado">Avaluo</th>
					@endif
					<th class="centrado">Fecha</th>
					<th class="centrado">Hora</th>
					<th>Cliente</th>
					<th>Tipo</th>
					<th>Dirección</th>
					<th>Telefono</th>
					<th>Estado</th>
					<th class="centrado">Hoja de Campo</th>
					<th class="centrado">Fotos</th>
					<th class="centrado">Comparables</th>
					<th class="centrado">Notas</th>
				</thead>
				<tbody>
					@foreach ($people->avaluos_inspector_hoy as $avaluo)
					<tr>
						@if (Auth::user()->people->city->country->nombre=='Bolivia')
						<td class="centrado">{{$avaluo->id}}</td>
						@endif
						<td class="centrado"><b>{{Carbon\Carbon::parse($avaluo->fecha_cita)->format('d/m/Y')}}</b></td>
						<td class="centrado"><b>{{Carbon\Carbon::parse($avaluo->fecha_cita)->format('H:i')}}</b></td>
						<td>{{$avaluo->client_nombre()}}</td>
						<td>{{$avaluo->type->codigo}}</td>
						<td style="white-space: pre-wrap; line-height: 14px; font-size: 13px;">{{$avaluo->direccion}}</td>
						<td>{{$avaluo->client->telefono." - ".$avaluo->client->telefono2}}</td>
						<td>{{$avaluo->estado}}</td>
						<td class="centrado">{!!link_to_action('IDCController@verhoja', $title = 'Ver Hoja', $parameters = $avaluo->id, $attributes = ['class'=>'btn default'])!!}</td>
						<td class="centrado">
							<button type="button" class="subir btn success" hoja="{{$avaluo->bank->hojadecampo}}" avaluo_id="{{$avaluo->id}}">Fotos</button>
						</td>
						<td class="centrado">
							@if ($avaluo->latitude!=null && $avaluo->longitude!=null)
							<button type="button" class="comparables btn info" avaluo_id="{{$avaluo->id}}" lat="{{$avaluo->latitude}}" lon="{{$avaluo->longitude}}" direccion="{{$avaluo->direccion}}">{{$avaluo->data->comparables}} C - {{$avaluo->data->avaluos}} A</button>
							@endif
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
<div class="card">
	<div class="card-header danger">
		<h5 class="card-title">Inspecciones Sin Enviar</h5>
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
					@if (Auth::user()->people->city->country->nombre=='Bolivia')
					<th>Id</th>
					@endif
					<th class="centrado">Fecha</th>
					<th class="centrado">Hora</th>
					<th>Día</th>
					<th>Cliente</th>
					<th>Dirección</th>
					<th>Telefono</th>
					<th class="centrado">Tipo</th>
					<th class="centrado">Comparables</th>
					<th class="centrado">IC</th>
					<th class="centrado">Estado</th>
					<th class="centrado">Notas</th>
				</thead>
				<tbody>
					@foreach($inspeccionessinenviar as $avaluo)
					<tr>
						@if (Auth::user()->people->city->country->nombre=='Bolivia')
						<td>{{$avaluo->id}}</td>
						@endif
						<td class="centrado"><b>{{Carbon\Carbon::parse($avaluo->fecha_cita)->format('d/m/Y')}}</b></td>
						<td class="centrado"><b>{{Carbon\Carbon::parse($avaluo->fecha_cita)->format('H:i')}}</b></td>
						<td><b>{{strtoupper(Jenssegers\Date\Date::parse($avaluo->fecha_cita)->format('l'))}}</b></td>
						<td>{{$avaluo->client_nombre()}}</td>
						<td style="white-space: pre-wrap; line-height: 14px; font-size: 13px;">{{$avaluo->direccion}}</td>
						<td>{{$avaluo->client->telefono." - ".$avaluo->client->telefono2}}</td>
						<td class="centrado"><b>{{$avaluo->type->codigo}}</b></td>
						<td class="centrado">
							@if ($avaluo->latitude!=null && $avaluo->longitude!=null)
							<button type="button" class="comparables btn info" avaluo_id="{{$avaluo->id}}" lat="{{$avaluo->latitude}}" lon="{{$avaluo->longitude}}" direccion="{{$avaluo->direccion}}">{{$avaluo->data->comparables}} C - {{$avaluo->data->avaluos}} A</button>
							@endif
						</td>
						<td class="centrado"><b>{{isset($avaluo->inspector_id)?$avaluo->inspector->codigo:''}}</b></td>
						<td class="centrado"><i><b>{{$avaluo->estado}}{!!$avaluo->sinDocumentos()!!}{!!$avaluo->prioridad()!!}</b></i></td>
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
@endsection
@section('adminjs')
<script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"></script>
{!!Html::script('js/libraries/grayscale.js')!!}
{!!Html::script('js/libraries/bundle.js')!!}
{!!Html::script('js/maps.js')!!}
{!!Html::script('js/libraries/morris.js')!!}
{!!Html::script('js/libraries/raphael.js')!!}
@endsection
@section('admincss')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" />
@endsection
