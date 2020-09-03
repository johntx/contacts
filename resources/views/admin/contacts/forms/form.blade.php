<div class="form-group">
	{!! Form::label('Fisrt Name') !!}
	{!! Form::text('first_name',$contact->first_name ?? null,['class'=>'form-control','placeholder'=>'Insert Fisrt Name','required', 'maxlength'=>255]) !!}
</div>
<div class="form-group">
	{!! Form::label('Last Name') !!}
	{!! Form::text('last_name',$contact->last_name ?? null,['class'=>'form-control','placeholder'=>'Insert Last Name','maxlength'=>255]) !!}
</div>
<div class="form-group">
	{!! Form::label('Email') !!}
	{!! Form::text('email',$contact->email ?? null,['class'=>'form-control','placeholder'=>'Insert Email','maxlength'=>200,'autocomplete'=>'off']) !!}
</div>
<div class="form-group">
	{!! Form::label('Contact Number') !!}
	{!! Form::text('contact_number',$contact->contact_number ?? null,['class'=>'form-control','placeholder'=>'Insert Contact Number','maxlength'=>100,'autocomplete'=>'off']) !!}
</div>
