@extends('layouts.admin')
@section('content')
@include('alerts.request')
<div class="panel">
	<div class="panel-body">
		{!! Form::model($user,['route' => ['user.update',$user->id],'method'=>'put']) !!}
		@include('user.forms.form')
		<div class="nb col-4">
			<div class="col-2">
				{!! Form::submit('Guardar',['class'=>'btn primary ancho bloquear_submit']) !!}
			</div>
		</div>
		{!! Form::close() !!}
	</div>
</div>
@endsection