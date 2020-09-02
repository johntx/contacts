@extends('layouts.html')
@section('content')
@include('alerts.request')
<div class="col-3 col-mid" style="margin-top: 40px;">
	<div class="panel default-soft">
		<div class="panel-body">
			{!! Form::open(['route' => 'user.store','method'=>'post']) !!}
			<div class="col-4">
				<div class="form-group">
					{!! Form::label('Nombre Completo*') !!}
					{!! Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Ingrese su Nombre completo','required', 'maxlength'=>200,'autocomplete'=>'off']) !!}
				</div>
			</div>
			<div class=" col-4">
				<div class=" col-4">
					<div class="form-group">
						{!! Form::label('Telefono') !!}
						{!! Form::text('telefono',null,['class'=>'form-control','placeholder'=>'Ingrese su Telefono', 'maxlength'=>100,'autocomplete'=>'off']) !!}
					</div>
				</div>
				<div class=" col-4">
					<div class="form-group">
						{!! Form::label('Ciudad') !!}
						{!! Form::select('city_id', $cities, null, ['class'=>'form-control']) !!}
					</div>
				</div>
			</div>
			<div class=" col-4">
				<div class="form-group">
					{!! Form::label('Email') !!}
					{!! Form::email('user',null,['class'=>'form-control','placeholder'=>'Ingrese su Email' , 'required', 'maxlength'=>100,'autocomplete'=>'off']) !!}
				</div>
			</div>
			<div class=" col-4">
				<div class="form-group">
					{!! Form::label('Password') !!}
					{!! Form::password('password',['class'=>'form-control','placeholder'=>'Ingrese su Password', 'maxlength'=>60,'autocomplete'=>'off']) !!}
				</div>
			</div>
			<div class=" col-4">
				<div class="form-group">
					{!! Form::label('Tipo Usuario') !!}
				</div>
				<div class=" col-2">
					<em><b>&nbsp;&nbsp;&nbsp;Usuario:&nbsp; </b></em> <input type="radio" id="usuario_reg" name="tipo_user_reg" class="check-min">
					<em><b>&nbsp;&nbsp; Funcionario Bancario:&nbsp; </b></em> <input type="radio" id="bancario_reg" name="tipo_user_reg" class="check-min">
				</div>
			</div>
			<div class=" col-4">.</div>
			<div class=" col-4">
				<input type="hidden" name="role_id" value="{{\casas\Role::where('code','EXT')->first()->id}}">
				<input type="hidden" name="externo" value="externo">
			</div>
			<div class="col-4">
				<div class="col-2" id="asignar_area" style="display:none">
					<div class="panel success-soft">
						<div class="panel-heading">Asignar Area</div>
						<div class="panel-body">
							<div class="form-group">
								<div class="selectpicker">
									<a id="boton_select_agencia" class="btn form-control default">Seleccione una Area<i class="mdi mdi-menu-right"></i></a>
									<div>
										<input type="text" class="buscador" placeholder="Buscar..">
										<ul>
											<li class="list-group-item warning-soft add_area" id_subject="General" name_subject="General">
												<a  class="selectpicker-option" value="General"><b></b> General</a>
											</li>
											<li class="list-group-item warning-soft add_area" id_subject="Banca Persona" name_subject="BancaPersona">
												<a  class="selectpicker-option" value="BancaPersona"><b></b> Banca Persona</a>
											</li>
											<li class="list-group-item warning-soft add_area" id_subject="Banca Empresa" name_subject="BancaEmpresa">	
												<a  class="selectpicker-option" value="BancaEmpresa"><b></b> Banca Empresa</a>
											</li>
											<li class="list-group-item warning-soft add_area" id_subject="Banca MyPe" name_subject="BancaMyPe">		
												<a  class="selectpicker-option" value="BancaMyPe"><b></b> Banca MyPe</a>
											</li>
										</ul>
									</div>
								</div>
								<select name="" class="form-control selectpicker" id="" required>
									<option value="General">General</option>
									<option value="BancaPersona">Banca Persona</option>
									<option value="BancaEmpresa">Banca Empresa</option>
									<option value="BancaMyPe">Banca MyPe</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="col-2" id="area_seleccionada" style="display:none">
					<div class="panel info-soft nr">
						<div class="panel-heading">Areas Seleccionadas</div>
						<div class="panel-body">
							<ul class="list-group" id="list_areas">
								@if (isset($official))
								@foreach ($official->areas as $area)
								<li class='list-group-item danger-soft'>
									{{$area->area}}
									<button class='btn danger btn_quitar_subject' type='button'>&times;</button>
									<input type='hidden' name='areas[]' value='{{$area->id}}' >
								</li>
								@endforeach
								@endif
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class=" col-4">
				{!! Form::submit('Registrar',['class'=>'btn primary ancho']) !!}
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endsection
@section('adminjs')
<script>
	$('body').on('click','.btn_quitar_subject',function () {
		$(this).parent().remove();
	});
	$('body').on('click','.add_area',function () {
		$('#list_areas').append(
			"<li class='list-group-item danger-soft'>"
			+$(this).attr('name_subject')
			+"<button class='btn danger btn_quitar_subject' type='button'>&times;</button><input type='hidden' name='areas[]' value='"
			+$(this).attr('id_subject')
			+"' ></li>"
			);
	});
</script>
@endsection