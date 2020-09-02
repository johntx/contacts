<div class="form-group">
	{!! Form::label('Nombre*') !!}
	{!! Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Inserte Nombre','required', 'maxlength'=>200]) !!}
</div>
<div class="form-group">
	{!! Form::label('Cargo') !!}
	{!! Form::text('cargo',null,['class'=>'form-control','placeholder'=>'Inserte Cargo','maxlength'=>100]) !!}
</div>
<div class="form-group">
	{!! Form::label('Interno') !!}
	{!! Form::text('interno',null,['class'=>'form-control','placeholder'=>'Inserte Número Interno','maxlength'=>30,'autocomplete'=>'off']) !!}
</div>
<div class="form-group">
	{!! Form::label('Teléfono') !!}
	{!! Form::text('telefono',null,['class'=>'form-control','placeholder'=>'Inserte Teléfono','maxlength'=>100,'onkeypress'=>"return justNumbers(event);",'autocomplete'=>'off']) !!}
</div>
<div class="form-group">
	{!! Form::label('Correo') !!}
	{!! Form::text('correo',null,['class'=>'form-control','placeholder'=>'Inserte Correo','maxlength'=>150]) !!}
</div>
<div class="form-group">
	{!! Form::label('Banco - Agencia') !!}
	<div class="selectpicker">
		<a id="boton_select_agencia" class="btn form-control default" @if(isset($official->agency_id)){{str_replace("cambio",$official->agency->bank->color, "style=background-color:cambio;color:rgb(255,255,255);")}}@endif >@if(isset($official->agency_id)){{$official->agency->bank->nombre." - ".$official->agency->nombre}}@else{{'Seleccione un Banco - Agencia'}}@endif<i class="mdi mdi-menu-right"></i></a>
		<div>
			<input type="text" class="buscador" placeholder="Buscar..">
			<ul>
				@foreach ($agencies as $agency)
				<li>
					<a class="selectpicker-option @if(isset($official->agency_id)){{($official->agency_id==$agency->id)?'selected':''}}@endif" value="{{$agency->id}}"><b style="color: {{$agency->bank->color}};">{{$agency->bank->nombre}}</b> - {{$agency->nombre}}</a>
				</li>
				@endforeach
			</ul>
		</div>
	</div>
	<select name="agency_id" class="form-control selectpicker" id="agency_select" required>
		@foreach ($agencies as $agency)
		<option color="{{$agency->bank->color}}" @if(isset($official->agency_id)){{($official->agency_id==$agency->id)?'selected':''}}@endif value="{{$agency->id}}">{{$agency->bank->nombre}} - {{$agency->nombre}}</option>
		@endforeach
	</select>
</div>