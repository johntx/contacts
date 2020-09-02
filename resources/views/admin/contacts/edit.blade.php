@extends('layouts.admin')
@section('content')
@include('alerts.request')
<div class="panel">
	<div class="panel-body">
		{!! Form::model($official,['route' => ['admin.official.update',$official->id],'method'=>'put']) !!}
		@include('admin.official.forms.form')
		<div class="col-2 nb">
			{!! Form::submit('Guardar',['class'=>'btn primary col-4']) !!}
		</div>
		{!! Form::close() !!}
	</div>
</div>
@endsection