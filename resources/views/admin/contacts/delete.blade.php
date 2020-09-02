@extends('layouts.admin')
@section('content')
@include('alerts.request')
<div class="panel-">
	<div class="panel-body">
		{!! Form::model($official) !!}
		<div class="form-group">
			{!! Form::label('Nombre*') !!}
			{!! Form::label($official->nombre,null,['class'=>'form-control']) !!}
		</div>
		<div class="form-group">
			{!! Form::label('Agencia*') !!}
			{!! Form::select('agency_id', $agencies, null, ['class'=>'form-control','disabled']) !!}
		</div>
		<div class="form-group">
			{!! Form::label('Banco*') !!}
			{!! Form::select('bank_id', $banks, null, ['class'=>'form-control','disabled']) !!}
		</div>
		{!! Form::open(['route' => ['admin.official.destroy',$official->id],'method'=>'delete']) !!}
		{!! Form::submit('Borrar',['class'=>'btn danger']) !!}
		{!! Form::close() !!}
	</div>
</div>
@endsection