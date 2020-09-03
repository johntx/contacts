<div class="form-group">
	{!! Form::label('Full Name') !!}
	{!! Form::text('name',$user->name ?? null,['class'=>'form-control','placeholder'=>'Insert Full Name','required', 'maxlength'=>255]) !!}
</div>
<div class="form-group">
	{!! Form::label('Email') !!}
	{!! Form::text('email',$user->email ?? null,['class'=>'form-control','placeholder'=>'Insert Email','maxlength'=>200,'autocomplete'=>'off']) !!}
</div>