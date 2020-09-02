@if(Session::has('error'))
<div class="alert danger-soft ">
	<button type="button" class="close_alert"><span>&times;</span></button>
	{{Session::get('error')}}
</div>
@endif