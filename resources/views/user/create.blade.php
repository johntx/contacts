@extends('layouts.admin')
@section('content')
@include('alerts.request')
<div class="panel">
	<div class="panel-body">
		{!! Form::open(['route' => 'user.store','method'=>'post']) !!}
		@include('user.forms.form')
		<div class=" col-4">
			<div class="col-2">
				{!! Form::submit('Registrar',['class'=>'btn primary col-4']) !!}
			</div>
			<div class="col-2">
			</div>
		</div>
		{!! Form::close() !!}
	</div>
</div>
@endsection