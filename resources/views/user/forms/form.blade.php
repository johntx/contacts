<div class="col-4">
	<div class=" col-3">
		<div class="form-group">
			{!! Form::label('Nombre Completo*') !!}
			{!! Form::text('nombre',null,['class'=>'form-control','required', 'maxlength'=>200,'autocomplete'=>'off']) !!}
		</div>
	</div>
	<div class=" col-1">
		<div class="form-group">
			{!! Form::label('Numero de inspecciones almacenadas') !!}
			{!! Form::text('no_trabajo',null,['class'=>'form-control', 'maxlength'=>20,'autocomplete'=>'off','onkeypress'=>"return justNumbers(event);"]) !!}
		</div>
	</div>
</div>
<div class=" col-4">
	<div class=" col-1">
		<div class="form-group">
			{!! Form::label('Telefono') !!}
			{!! Form::text('telefono',null,['class'=>'form-control', 'maxlength'=>100,'autocomplete'=>'off']) !!}
		</div>
	</div>
	<div class=" col-1">
		<div class="form-group">
			{!! Form::label('Fecha de Ingreso') !!}
			{!! Form::text('fecha_ingreso',(isset($user->fecha_ingreso))?$user->fecha_ingreso:Carbon\Carbon::now()->format('Y-m-d'),['class'=>'form-control datepicker','autocomplete'=>'off']) !!}
		</div>
	</div>
	<div class=" col-1">
		<div class="form-group">
			{!! Form::label('Oficina') !!}
			{!! Form::select('office_id', $offices, null, ['class'=>'form-control']) !!}
		</div>
	</div>
	<div class=" col-1">
		<div class="form-group">
			{!! Form::label('Ciudad*') !!}
			{!! Form::select('city_id', $cities, null, ['class'=>'form-control']) !!}
		</div>
	</div>
</div></div></div><div class="panel"><div class="panel-body">
	<div class=" col-4">
		<div class=" col-2">
			<div class="form-group">
				{!! Form::label('Usuario') !!}
				{!! Form::text('user',null,['class'=>'form-control', 'required', 'maxlength'=>100,'autocomplete'=>'off']) !!}
			</div>
		</div>
		<div class=" col-1">
			<div class="form-group">
				{!! Form::label('Número de Inspector (CODIGO)') !!}
				{!! Form::text('codigo',null,['class'=>'form-control', 'maxlength'=>20,'autocomplete'=>'off']) !!}
			</div>
		</div>
		<div class=" col-1">
			<div class="form-group">
				{!! Form::label('Orden en lista') !!}
				{!! Form::text('orden',null,['class'=>'form-control', 'maxlength'=>20,'autocomplete'=>'off','onkeypress'=>"return justNumbers(event);"]) !!}
			</div>
		</div>
	</div>
	<div class=" col-4">
		<div class="form-group">
			{!! Form::label('Password') !!}
			{!! Form::password('password',['class'=>'form-control', 'maxlength'=>60,'autocomplete'=>'off']) !!}
		</div>
	</div>
	<div class=" col-4">
		@foreach($roles as $key => $role)
		<div class=" col-1">
			<div class="form-group">
				{!! Form::checkbox('roles[]',$role->id,null,['id'=>$role->code]) !!}
				<label for="{{$role->code}}">{{$role->name}}</label>
			</div>
		</div>
		@endforeach
	</div>
	<div class=" col-4">
		<div class="form-group">
			{!! Form::label('Color') !!}
			{!! Form::color('color',(isset($user->color))?$user->color:"#FFFFFF") !!}
		</div>
	</div>
</div></div><div class="panel"><div class="panel-body">
	<div class="table-responsive">
		<table>
			<thead>
				@foreach ($dias as $dia)
				<th class="centrado th_dia" dia="{{$dia}}">{{ucfirst($dia)}}</th>
				@endforeach
			</thead>
			<tbody>
				<tr>
					@foreach ($dias as $dia)
					<td class="centrado td_dia" dia="{{$dia}}">
						<div class=" col-4">
							<p>De:</p>{!! Form::select('entrada_'.$dia, $horas,($dia=='sabado')?null:'08:00') !!}<p>a:</p>{!! Form::select('salida_'.$dia, $horas, ($dia=='sabado')?null:'12:00') !!}
						</div>
					</td>
					@endforeach
				</tr>
				<tr>
					@foreach ($dias as $dia)
					<td class="centrado td_dia" dia="{{$dia}}">
						<div class=" col-4">
							<p>De:</p>{!! Form::select('entrada2_'.$dia, $horas, null) !!}<p>a:</p>{!! Form::select('salida2_'.$dia, $horas, null) !!}
						</div>
					</td>
					@endforeach
				</tr>
			</tbody>
		</table>
	</div>
</div></div><div class="panel"><div class="panel-body">