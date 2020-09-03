@extends('layouts.admin')
@section('content')
@include('alerts.request')
<div class="panel">
	<div class="panel-body">
		<form action="{{url('/admin/contacts')}}" method="post" accept-charset="utf-8">
			{{ csrf_field() }}
		@include('admin.contacts.forms.form')
		<div class="col-2 nb">
			{!! Form::submit('Registrar',['class'=>'btn primary col-4']) !!}
		</div>
		</form>
	</div>
</div>
@endsection