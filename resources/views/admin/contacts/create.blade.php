@extends('layouts.admin')
@section('content')
@include('alerts.request')
<div class="panel">
	<div class="panel-body">
		{!! Form::open(['route' => 'admin.official.store','method'=>'post']) !!}
		@include('admin.official.forms.form')
		<div class="col-2 nb">
			{!! Form::submit('Registrar',['class'=>'btn primary col-4']) !!}
		</div>
		{!! Form::close() !!}
	</div>
</div>
@endsection