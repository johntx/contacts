@extends('layouts.admin')
@section('content')
@include('modal.maps')
@include('modal.files')
@include('modal.enviarobs')
@include('modal.verobservados')
@include('modal.enviarobsgab')
<?php
$peoples->each(function ($people)
{
	$people->avaluos = count($people->avaluos_inspector_hoy);
});
$editar=false;$asignar=false;$devolver=false;$crearobs=false; $crearbd=true;
foreach (Auth::user()->all_functions() as $func) {
	if ($func->code=='EAVA'){ $editar=true; }
	if ($func->code=='ASIG'){ $asignar=true; }
	if ($func->code=='DEVOL'){ $devolver=true; }
	if ($func->code=='COBS'){ $crearobs=true; }
	if ($func->code=='COBS'){ $crearbd=false; }
}
?>
<script>
	document.title = "Gabinete";
</script>
@if ($crearobs)
    <div class="card borde_coral">
			<div class="card-header color_coral" >
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
							<th class="centrado">IC</th>
							<!--<th class="centrado">IG</th>-->
							<th class="centrado">Estado</th>
							<th class="centrado">Responsable</th>
							<th class="centrado">Tiempo Trabajo</th>
							<th class="centrado">Obs</th>
							<th class="centrado">Notas</th>
						</thead>
						<tbody>
							@foreach($observados as $avaluo)
							<tr>
								<td>{{$avaluo->observacion_id}}</td>
								<td class="centrado"><b>{{Carbon\Carbon::parse($avaluo->fecha_obs)->format('d/m/Y')}}</b></td>
								<td class="centrado"><b>{{Carbon\Carbon::parse($avaluo->fecha_cita)->format('d/m/Y')}}</b></td>
								<td>{{$avaluo->client_nombre()}}</td>
								<td>{{$avaluo->bank->nombre}}</td>
								<td class="centrado"><b>{{$avaluo->inspector->codigo}}</b></td>
								<!--<td class="centrado"><b>{{$avaluo->gabinete->codigo}}</b></td>-->
								<td class="centrado"><i><b>EN PROCESO</b></i></td>
								<td class="centrado"><b>{{$avaluo->people_nombre}}</b></td>
								<td class="centrado"><b>{{Jenssegers\Date\Date::parse(Carbon\Carbon::now())->diffForHumans($avaluo->fecha_fase)}}</b></td>		
								<td class="centrado">
										 {!!link_to_action('ObservacionesController@obs', $title = 'Obs', $parameters = $avaluo->avaluo_id, $attributes = ['class'=>'btn danger'])!!}
									</td>
								<td class="centrado">
									<div class="button_contenedor"><button class="btn btn-circle info btn_notas" avaluo_id="{{$avaluo->avaluo_id}}">{!!count($avaluo->notes)>0?"<i>".count($avaluo->notes)."</i>":''!!}💬</button></div>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
	</div>
@endif
@if ($crearbd)
	<div class="card">
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
						<!--<input type="search"  placeholder="Filtro:">-->
					</div>
				</div>
				<div class="contenedor-table-responsive">
			       <div class="table-responsive">
						<table class="table">
							<thead>
								<th>Id</th>
								<th class="centrado">Fecha Obs</th>
								<th class="centrado">Cliente</th>
								<th class="centrado">Tipo</th>
								<th class="centrado">Telefono</th>
								<th class="centrado">Dirección</th>
								<th class="centrado">Mapa</th>
								<th class="centrado">Estado</th>
								<th class="centrado">Notas</th>
								<th class="centrado">Enviar</th>
								<th class="centrado">Marcar Terminado</th>
								<th ></th>
							</thead>
							<tbody>
								@foreach($observadosbd as $avaluobd)
								<tr class="color_coral">
										<td colspan="11" onclick="verobservados('{{$avaluobd->tipo_observacion}}','{{$avaluobd->observacion}}','{{ Jenssegers\Date\Date::parse($avaluobd->fecha)->format('j M Y H:i')}}','{{$avaluobd->avaluo_id}}','{{$avaluobd->codigo}}','{{$avaluobd->tarea}}','{{$avaluobd->observacion_id}}')">
										    {{$avaluobd->tarea}}
										</td>
									</tr>
								<tr>
									<td>{{$avaluobd->observacion_id}}</td>								
									<td class="centrado"><b>{{Carbon\Carbon::parse($avaluobd->fase_fecha)->format('d-m-Y (H:i)')}}</b></td>
									<td>{{$avaluobd->client_nombre()}}</td>
									<td class="centrado"><b>{{$avaluobd->type->codigo}}</b></td>
									<td>{{$avaluobd->client->telefono." - ".$avaluobd->client->telefono2}}</td>
									<td style="white-space: pre-wrap; line-height: 14px; font-size: 13px;">{{$avaluobd->direccion}}</td>
									<td class="centrado">
										@if ($avaluobd->latitude!=null && $avaluobd->longitude!=null)
										<button type="button" class="comparables btn info" avaluo_id="{{$avaluobd->avaluo_id}}" lat="{{$avaluobd->latitude}}" lon="{{$avaluobd->longitude}}" direccion="{{$avaluobd->direccion}}">{{$avaluobd->comparables}} C - {{$avaluobd->avaluos}} A</button>
										@endif
									</td>
									<td class="centrado"><i><b>{{$avaluobd->estado}}{!!$avaluobd->sinDocumentos()!!}{!!$avaluobd->prioridad()!!}</b></i></td>
									<!--
									<td class="centrado">
									@if ($avaluobd->estado != 'ESPERA' && $avaluobd->estado != 'INSPECCION' && $avaluobd->estado != 'TERMINADO')
									{!!link_to_action('IDCController@verhoja', $title = 'Ver Hoja', $parameters = $avaluobd->id, $attributes = ['class'=>'btn default'])!!}
									@else
									{!!link_to_action('IDCController@hojadecampo', $title = 'Hoja', $parameters = $avaluobd->avaluo_id, $attributes = ['class'=>'btn primary'])!!}
									@endif
									</td>-->
									<td class="centrado">
									<div class="button_contenedor"><button class="btn btn-circle info btn_notas" avaluo_id="{{$avaluobd->avaluo_id}}">{!!count($avaluobd->notes)>0?"<i>".count($avaluobd->notes)."</i>":''!!}💬</button></div>
								    </td>
									<td class="centrado">
									  <button type="button" class="btn success" onclick="enviarobs({{$avaluobd->observacion_id}})">ENVIAR</button>
									</td>
									<td class="centrado">
									  <button type="button" class="btn danger" onclick="enviarobsgab({{$avaluobd->observacion_id}})">Termina ►</button>
									</td>
									
								</tr>
								@endforeach
							</tbody>
						</table>
				    </div>
				</div>
			</div>
		</div>
	</div>
@endif
@foreach($peoples->sortByDesc('avaluos') as $people)
@if (!(count($people->avaluos_gabinete_hoy)==0 && ($people->codigo==2 || $people->codigo==4 || $people->codigo==6)))
<div class="card">
	<div class="card-header info-soft">
		<h5 class="card-title" style="color: black;"><b>Inspector de Gabinete : {{$people->codigo}}</b></h5><b>{{$people->nombre}}</b><span><b>Trabajos por Día: {{$people->trabajos_por_dia()}}</b></span><span>id: {{$people->id}}</span>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table min">
				<thead>
					<th>Avaluo</th>
					<th>Fecha Cita</th>
					<th>Cliente</th>
					<th class="centrado">Tipo</th>
					<th class="centrado">Fecha Inicio de Trabajo</th>
					<th class="centrado">Codigo</th>
					<th class="centrado">Comparables</th>
					<th class="centrado">IC</th>
					<th>Estado</th>
					<th class="centrado">Monto</th>
					<th class="centrado">Fotos</th>
					@if ($asignar)<th class="centrado">Asignar</th>@endif
					<th class="centrado">Notas</th>
				</thead>
				<tbody>
					@foreach ($people->avaluos_gabinete_hoy as $avaluo)
					<tr>
						<td>{{$avaluo->id}}</td>
						<td>{{Carbon\Carbon::parse($avaluo->fecha_cita)->format('d/m/Y')}}</td>
						<td><b>{{$avaluo->client_nombre()}}</b></td>
						<td class="centrado"><b>{{$avaluo->type->codigo}}</b></td>
						<td class="centrado"><b>{{isset($avaluo->data->fecha_inicio_gabinete)?Carbon\Carbon::parse($avaluo->data->fecha_inicio_gabinete)->format('d/m/Y (H:i)'):''}}</b></td>
						<th class="centrado">{{$avaluo->codigo}}</th>
						<td class="centrado">
							@if ($avaluo->latitude!=null && $avaluo->longitude!=null)
							<button type="button" class="comparables btn info" avaluo_id="{{$avaluo->id}}" lat="{{$avaluo->latitude}}" lon="{{$avaluo->longitude}}" direccion="{{$avaluo->direccion}}">{{$avaluo->data->comparables}} C - {{$avaluo->data->avaluos}} A</button>
							@endif
						</td>
						<td class="centrado"><b>{{$avaluo->inspector->codigo}}</b></td>
						<td>{{$avaluo->estado}}{!!$avaluo->sinDocumentos()!!}{!!$avaluo->prioridad()!!}{!!$avaluo->reavaluo()!!}</td>
						<td class="centrado">{{$avaluo->abonos()==$avaluo->precio?'PAGADO':($avaluo->abonos()>0?'ANTICIPO':'DEBE')}}</td>
						<td class="centrado">
							<button type="button" class="subir btn success" hoja="{{$avaluo->bank->hojadecampo}}" avaluo_id="{{$avaluo->id}}">Fotos</button>
						</td>
						@if ($asignar)
						<td class="centrado">
							{!! Form::open(['url'=>'admin/asignar']) !!}
							<select name="gabinete_id" type="button" class="btn btn-min warning asignar_gabinete">
								<option value selected disabled>ASIGNAR</option>
								@foreach ($lista_asignar as $opcion)
								<option value="{{$opcion['id']}}" {{($opcion['id']==$people->id)?"disabled style=background-color:#BAE0C7;":''}}>{{$opcion['nombre']}}</option>
								@endforeach
								<option value="ENVIADO">ESPERA</option>
							</select>
							<input type="hidden" name="avaluo_id" value="{{$avaluo->id}}">
							<input type="hidden" name="root" value="no">
							{!! Form::close() !!}
						</td>
						@endif
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
@endif
@endforeach
<div class="card">
	<div class="card-header primary-low">
		<h5 class="card-title">Avaluos en Espera</h5>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table min">
				<thead>
					<th>Id</th>
					<th>Fecha Cita</th>
					<th>Cliente</th>
					<th class="centrado">Tipo</th>
					<th class="centrado">Banco</th>
					<th class="centrado">Monto</th>
					<th class="centrado">Comparables</th>
					<th class="centrado">IC</th>
					<th class="centrado">Estado</th>
					@if ($asignar)<th class="centrado">Asignar</th>@endif
					<th class="centrado">Notas</th>
					@if ($devolver)<th class="centrado">Devolver</th>@endif
				</thead>
				<tbody>
					@foreach($en_espera as $avaluo)
					<tr>
						<td>{{$avaluo->id}}</td>
						<td><b>{{Carbon\Carbon::parse($avaluo->fecha_cita)->format('d-m-Y')}}</b></td>
						<td>{{$avaluo->client_nombre()}}</td>
						<td class="centrado"><b>{{$avaluo->type->codigo}}</b></td>
						<td class="centrado">{{$avaluo->bank->letra}}</td>
						<td class="centrado">{{$avaluo->abonos()==$avaluo->precio?'PAGADO':($avaluo->abonos()>0?'ANTICIPO':'DEBE')}}</td>
						<td class="centrado">
							@if ($avaluo->latitude!=null && $avaluo->longitude!=null)
							<button type="button" class="comparables btn info" avaluo_id="{{$avaluo->id}}" lat="{{$avaluo->latitude}}" lon="{{$avaluo->longitude}}" direccion="{{$avaluo->direccion}}">{{$avaluo->data->comparables}} C - {{$avaluo->data->avaluos}} A</button>
							@endif
						</td>
						<td class="centrado"><b>{{$avaluo->inspector->codigo}}</b></td>
						<td class="centrado"><i><b>{{$avaluo->estado}}{!!$avaluo->sinDocumentos()!!}{!!$avaluo->prioridad()!!}{!!$avaluo->reavaluo()!!}</b></i></td>
						@if ($asignar)
						<td class="centrado">
							{!! Form::open(['url'=>'admin/asignar']) !!}
							<select name="gabinete_id" type="button" class="btn btn-min warning asignar_gabinete">
								<option value selected disabled>ASIGNAR</option>
								@foreach ($lista_asignar as $opcion)
								<option value="{{$opcion['id']}}">{{$opcion['nombre']}}</option>
								@endforeach
								<option value="ENVIADO">ESPERA</option>
							</select>
							<input type="hidden" name="avaluo_id" value="{{$avaluo->id}}">
							{!! Form::close() !!}
						</td>
						@endif
						<td class="centrado">
							<div class="button_contenedor"><button class="btn btn-circle info btn_notas" avaluo_id="{{$avaluo->id}}">{!!count($avaluo->notes)>0?"<i>".count($avaluo->notes)."</i>":''!!}💬</button></div>
						</td>
						@if ($devolver)
						<td class="centrado">
							{!!link_to_action('IDCController@devolver', $title = '◂ Devolver', $parameters = $avaluo->id, $attributes = ['class'=>'btn danger confirmacion'])!!}
						</td>
						@endif
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="card">
	<div class="card-header default">
		<h5 class="card-title">Sin Documentos</h5>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table min">
				<thead>
					<th>Id</th>
					<th>Fecha Cita</th>
					<th>Cliente</th>
					<th class="centrado">Tipo</th>
					<th class="centrado">Banco</th>
					<th class="centrado">Monto</th>
					<th class="centrado">Comparables</th>
					<th class="centrado">IC</th>
					<th class="centrado">Estado</th>
					@if ($asignar)<th class="centrado">Asignar</th>@endif
					<th class="centrado">Notas</th>
					@if ($devolver)<th class="centrado">Devolver</th>@endif
				</thead>
				<tbody>
					@foreach($sin_documentos as $avaluo)
					@if (!$avaluo->sinDocumentos=="")
					<tr>
						<td>{{$avaluo->id}}</td>
						<td><b>{{Carbon\Carbon::parse($avaluo->fecha_cita)->format('d-m-Y')}}</b></td>
						<td>{{$avaluo->client_nombre()}}</td>
						<td class="centrado"><b>{{$avaluo->type->codigo}}</b></td>
						<td class="centrado">{{$avaluo->bank->letra}}</td>
						<td class="centrado">{{$avaluo->abonos()==$avaluo->precio?'PAGADO':($avaluo->abonos()>0?'ANTICIPO':'DEBE')}}</td>
						<td class="centrado">
							@if ($avaluo->latitude!=null && $avaluo->longitude!=null)
							<button type="button" class="comparables btn info" avaluo_id="{{$avaluo->id}}" lat="{{$avaluo->latitude}}" lon="{{$avaluo->longitude}}" direccion="{{$avaluo->direccion}}">{{$avaluo->data->comparables}} C - {{$avaluo->data->avaluos}} A</button>
							@endif
						</td>
						<td class="centrado"><b>{{$avaluo->inspector->codigo}}</b></td>
						<td class="centrado"><i><b>{{$avaluo->estado}}{!!$avaluo->sinDocumentos()!!}{!!$avaluo->prioridad()!!}{!!$avaluo->reavaluo()!!}</b></i></td>
						@if ($asignar)
						<td class="centrado">
							{!! Form::open(['url'=>'admin/asignar']) !!}
							<select name="gabinete_id" type="button" class="btn btn-min warning asignar_gabinete">
								<option value selected disabled>ASIGNAR</option>
								@foreach ($lista_asignar as $opcion)
								<option value="{{$opcion['id']}}">{{$opcion['nombre']}}</option>
								@endforeach
								<option value="ENVIADO">ESPERA</option>
							</select>
							<input type="hidden" name="avaluo_id" value="{{$avaluo->id}}">
							{!! Form::close() !!}
						</td>
						@endif
						<td class="centrado">
							<div class="button_contenedor"><button class="btn btn-circle info btn_notas" avaluo_id="{{$avaluo->id}}">{!!count($avaluo->notes)>0?"<i>".count($avaluo->notes)."</i>":''!!}💬</button></div>
						</td>
						@if ($devolver)
						<td class="centrado">
							{!!link_to_action('IDCController@devolver', $title = '◂ Devolver', $parameters = $avaluo->id, $attributes = ['class'=>'btn danger confirmacion'])!!}
						</td>
						@endif
					</tr>
					@endif
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="card">
	<div class="card-header danger">
		<h5 class="card-title">Sin Pagos</h5>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table min">
				<thead>
					<th>Id</th>
					<th>Fecha Cita</th>
					<th>Cliente</th>
					<th class="centrado">Tipo</th>
					<th class="centrado">Banco</th>
					<th class="centrado">Monto</th>
					<th class="centrado">Comparables</th>
					<th class="centrado">IC</th>
					<th class="centrado">Estado</th>
					@if ($asignar)<th class="centrado">Asignar</th>@endif
					<th class="centrado">Notas</th>
					@if ($devolver)<th class="centrado">Devolver</th>@endif
				</thead>
				<tbody>
					@foreach($sin_pagar as $avaluo)
					<tr>
						<td>{{$avaluo->id}}</td>
						<td><b>{{Carbon\Carbon::parse($avaluo->fecha_cita)->format('d-m-Y')}}</b></td>
						<td>{{$avaluo->client_nombre()}}</td>
						<td class="centrado"><b>{{$avaluo->type->codigo}}</b></td>
						<td class="centrado">{{$avaluo->bank->letra}}</td>
						<td class="centrado">{{$avaluo->abonos()==$avaluo->precio?'PAGADO':($avaluo->abonos()>0?'ANTICIPO':'DEBE')}}</td>
						<td class="centrado">
							@if ($avaluo->latitude!=null && $avaluo->longitude!=null)
							<button type="button" class="comparables btn info" avaluo_id="{{$avaluo->id}}" lat="{{$avaluo->latitude}}" lon="{{$avaluo->longitude}}" direccion="{{$avaluo->direccion}}">{{$avaluo->data->comparables}} C - {{$avaluo->data->avaluos}} A</button>
							@endif
						</td>
						<td class="centrado"><b>{{$avaluo->inspector->codigo}}</b></td>
						<td class="centrado"><i><b>{{$avaluo->estado}}{!!$avaluo->sinDocumentos()!!}{!!$avaluo->prioridad()!!}{!!$avaluo->reavaluo()!!}</b></i></td>
						@if ($asignar)
						<td class="centrado">
							{!! Form::open(['url'=>'admin/asignar']) !!}
							<select name="gabinete_id" type="button" class="btn btn-min warning asignar_gabinete">
								<option value selected disabled>ASIGNAR</option>
								@foreach ($lista_asignar as $opcion)
								<option value="{{$opcion['id']}}">{{$opcion['nombre']}}</option>
								@endforeach
								<option value="ENVIADO">ESPERA</option>
							</select>
							<input type="hidden" name="avaluo_id" value="{{$avaluo->id}}">
							{!! Form::close() !!}
						</td>
						@endif
						<td class="centrado">
							<div class="button_contenedor"><button class="btn btn-circle info btn_notas" avaluo_id="{{$avaluo->id}}">{!!count($avaluo->notes)>0?"<i>".count($avaluo->notes)."</i>":''!!}💬</button></div>
						</td>
						@if ($devolver)
						<td class="centrado">
							{!!link_to_action('IDCController@devolver', $title = '◂ Devolver', $parameters = $avaluo->id, $attributes = ['class'=>'btn danger confirmacion'])!!}
						</td>
						@endif
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="card">
	<div class="card-header warning">
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
			<table class="table min">
				<thead>
					<th>Id</th>
					<th class="centrado">Fecha</th>
					<th class="centrado">Hora</th>
					<th>Día</th>
					<th>Cliente</th>
					<th class="centrado">Tipo</th>
					<th class="centrado">Comparables</th>
					<th class="centrado">IC</th>
					<th class="centrado">Estado</th>
					<th class="centrado">Abono</th>
					<th class="centrado">Costo</th>
					<th class="centrado">Saldo</th>
					<th class="centrado">Monto</th>
					<th class="centrado">Notas</th>
				</thead>
				<tbody>
					@foreach($sin_enviar as $avaluo)
					<tr>
						<td>{{$avaluo->id}}</td>
						<td class="centrado"><b>{{Carbon\Carbon::parse($avaluo->fecha_cita)->format('d/m/Y')}}</b></td>
						<td class="centrado"><b>{{Carbon\Carbon::parse($avaluo->fecha_cita)->format('H:i')}}</b></td>
						<td><b>{{strtoupper(Jenssegers\Date\Date::parse($avaluo->fecha_cita)->format('l'))}}</b></td>
						<td>{{$avaluo->client_nombre()}}</td>
						<td class="centrado"><b>{{$avaluo->type->codigo}}</b></td>
						<td class="centrado">
							@if ($avaluo->latitude!=null && $avaluo->longitude!=null)
							<button type="button" class="comparables btn info" avaluo_id="{{$avaluo->id}}" lat="{{$avaluo->latitude}}" lon="{{$avaluo->longitude}}" direccion="{{$avaluo->direccion}}">{{$avaluo->data->comparables}} C - {{$avaluo->data->avaluos}} A</button>
							@endif
						</td>
						<td class="centrado"><b>{{isset($avaluo->inspector)?$avaluo->inspector->codigo:''}}</b></td>
						<td class="centrado"><i><b>{{$avaluo->estado}}{!!$avaluo->sinDocumentos()!!}{!!$avaluo->prioridad()!!}</b></i></td>
						<td class="centrado"><b>{{$avaluo->abono}}</b></td>
						<td class="centrado">{{$avaluo->precio}}</td>
						<td class="centrado">{{$avaluo->precio-$avaluo->abono}}</td>
						<td class="centrado">{{$avaluo->abonos()==$avaluo->precio?'PAGADO':($avaluo->abonos()>0?'ANTICIPO':'DEBE')}}</td>
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
{!!Html::script('js/maps.js')!!}
{!!Html::script('js/libraries/bundle.js')!!}
{!!Html::script('js/libraries/morris.js')!!}
{!!Html::script('js/libraries/raphael.js')!!}
@endsection
@section('admincss')
{!!Html::style('css/morris.css')!!}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" />
@endsection
