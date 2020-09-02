@if(Session::has('success'))
<div class="alert success-soft ">
	<button type="button" class="close_alert"><span>&times;</span></button>
	{{Session::get('success')}}
</div>
@endif