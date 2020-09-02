$('document').ready(function(){
	var tamano = parseInt($('.nav_menu.active').children('ul').attr('tamano'));
	$('.nav_menu.active').children('ul').animate({
		paddingTop : 15,
		paddingBottom : 15,
		height: tamano+"px"
	}, 300 );
});
$('.pdfbtn').click(function() {
	modalcode('modal-pdf');
	$(".modal-dialog iframe").attr('src',$(this).attr('href'));
	$(".modal-dialog .panel-title").html('PDF ID: '+$(this).attr('code'));
	cortina();
	return false;
});
$('body').on('keyup','.buscador',function (e) {
	var input, filter, ul, li, a, i;
	input = $(this);
	filter = input.val().toUpperCase();
	ul = $(this).siblings('ul');
	li = ul.children("li");
	if($(ul).css('display') !== 'block'){
		$(ul).css('display','block');
	}
	for (i = 0; i < li.length; i++) {
		a = li[i].getElementsByTagName("a")[0];
		if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
			li[i].style.display = "block";
		} else {
			li[i].style.display = "none";
		}
	}
});
function ocultar_cortina() {
	if ($('.modal-dialog').hasClass('visible')) {
		$(".modal-dialog iframe").attr('src','');
	}
	$('#cortina').removeClass('cortina');
	$('.visible').removeClass('visible');
	$('aside').removeClass('mostrar');
}
function modal() {
	$('.modal-dialog').addClass('visible');
}
function modalcode(code) {
	$('.modal-dialog.'+code).addClass('visible');
	$('input.abono').focus();
}
function cortina() {
	$('#cortina').addClass('cortina');
}

function buscar(i){
	$(i).parent().addClass('visible');
	$(i).parent().children('input').select();
	$(i).parent().children('input').focus();
	cortina();
}
function desplegar_log(i){
	$(i).parent().addClass('visible');
	cortina();
}
$('body').on('click','li.nav_menu>a',function (e) {
	if (e.target == this) {
		var ul = $(this).siblings('ul');
		var tamano = parseInt($(this).siblings('ul').attr('tamano'));
		if ($(this).parent().hasClass('active')) {
			if ($(this).siblings('ul').attr('style')==null) {
				$(this).siblings('ul').attr('style',"padding-top: 15px; padding-bottom: 15px; height: "+tamano+"px; opacity: 1;")
			}
			$(this).siblings('ul').animate({
				paddingTop : 0,
				paddingBottom : 0,
				height: "0px"
			}, 300 );
			$(this).parent().removeClass('active');
		} else {
			$('li.nav_menu.active').children('ul').animate({
				paddingTop : 0,
				paddingBottom : 0,
				height: "0px"
			}, 300 );
			$('li.nav_menu').removeClass('active');

			$(this).siblings('ul').animate({
				paddingTop : 15,
				paddingBottom : 15,
				height: tamano+"px"
			}, 300 );
			$(this).parent().addClass('active');
		}
	}
});
$('body').on('click','ul.tab-nav>li',function (e) {
	var tab = $(this).attr('tab');
	$('.tab-active').removeClass('tab-active');
	$(this).addClass('tab-active');
	$('.tab-panel[tab="'+tab+'"]').addClass('tab-active');
});
$('body').on('click','.text-select>ul>li>a',function (e) {
	var ul = $(this).parent('li').parent('ul');
	ul.siblings('input').val($(this).html());
});
$(".conte>div.body").on("scroll", function() {
	$("div.nombres>.body").scrollTop($(this).scrollTop());
	$(".conte>div.header").scrollLeft($(this).scrollLeft());
});
$('.asis_hover>div>div').hover(function() {
	var ins = '.'+$(this).parent().parent().attr('ins');
	$(ins).children().attr('style','background-color: rgba(0,0,0,0.6);color:#FFF;');
	var asis = '.'+$(this).attr('asis');
	var stilo_asis = $(asis).attr('style');
	$(asis).attr('style',stilo_asis+'background-color:rgba(156,39,176,0.3);');
},function() {
	var ins = '.'+$(this).parent().parent().attr('ins');
	$(ins).children().removeAttr('style');
	var asis = '.'+$(this).attr('asis');
	var stilo_asis = $(asis).attr('style');
	var res = stilo_asis.replace("background-color:rgba(156,39,176,0.3);", "");
	$(asis).attr('style',res);
});
$('body').on('click','.nombre_modulo',function (e) {
	if ($(this).hasClass('promo')) {
		return null;
	} else {
		var padre = $(this).parent().width();
		var modulo = $(this).parent().attr('modulo');
		if (padre > 150) {
			$(this).css({'top':'10px'});
			$(this).parent().width(150);
			$(this).parent().css({'overflow':'hidden'});
			$(".body_modulos[modulo='"+modulo+"']").width(150);
			$(".body_modulos[modulo='"+modulo+"']").css({'overflow':'hidden'});
		}
		if (padre <= 150) {
			$(this).removeAttr('style');
			$(this).parent().removeAttr('style');
			$(".body_modulos[modulo='"+modulo+"']").removeAttr('style');
		}
	}
});
function mostrar_aside() {
	$('aside').addClass('mostrar');
	cortina();
}
$('body').on('click','.btn-modal',function (e) {
	var modal = '.'+$(this).attr('modal');
	$(modal).addClass('visible');
	cortina();
});
$('body').on('click','div.selectpicker>a',function (e) {
	var div = $(this).siblings('div');
	if (div.hasClass('desplegado')) {
		div.removeClass('desplegado');
	} else {
		div.addClass('desplegado');
		div.children('input').select();
		div.children('input').focus();
	}
});
$('input.buscador').focusout(function() {
	if ($(this).siblings('ul').is(":hover")) {}else{
		$(this).parent().removeClass('desplegado');
	}
})
$('body').on('click','.selectpicker-option',function (e) {
	var valu = $(this).attr('value');
	var div_padre = $(this).parent().parent().parent();
	var select = div_padre.parent().siblings('select.selectpicker');
	$(select).children('option[value="'+valu+'"]').prop('selected', true);
	$(select).trigger('change');
	var nom = $(select).children('option:selected').html();
	$(this).parent().siblings('li').children('a').removeClass('selected');
	$(this).addClass('selected');
	div_padre.siblings('a').html(nom+'<i class="mdi mdi-menu-right">');
	div_padre.removeClass('desplegado');
});