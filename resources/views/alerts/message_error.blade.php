@if(Session::has('message_error'))
<div class="alert danger-soft ">
	<button type="button" class="close_alert"><span>&times;</span></button>
	{!!Session::get('message_error')!!}
</div>
@endif
