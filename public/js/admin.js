$('document').ready(function(){
	setTimeout(function() {$(".alert").fadeOut(1000);},4000);
	$('.close_alert').click(function() {$(this).parent('.alert').fadeOut(500);});
});