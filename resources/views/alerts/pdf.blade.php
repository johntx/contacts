@if(Session::has('pdf'))
<script type="text/javascript">
	window.open('{!! url(Session::get('pdf')) !!}');
</script>
@endif
<div class="modal-dialog panel panel-default modal-pdf">
	<div class="panel-heading">
		<h4 class="panel-title">RECIBO nia</h4>
		<a class="btn-close btn danger" onclick="ocultar_cortina();">&times;</a>
	</div>
	<div class="panel-body">
		<iframe src="" style="width:100%; height:80%;" frameborder="0"></iframe>
	</div>
</div>