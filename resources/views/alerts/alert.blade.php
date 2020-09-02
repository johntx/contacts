@if(Session::has('alert'))
<div class="alert warning-soft ">
	<button type="button" class="close_alert"><span>&times;</span></button>
	{{Session::get('alert')}}
</div>
@endif