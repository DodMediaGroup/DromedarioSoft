jQuery(document).ready(function($) {
	$(document).on('submit', '.form__ajax', function(event) {
		event.preventDefault();
		$.sendFormAjax($(this));
	});
	$(document).on('click', '.link__ajax', function(event) {
		event.preventDefault();
		$.linkAjax($(this));
	});
	$(document).on('click', '.link__confirm', function(event) {
		event.preventDefault();
		$.showConfirm($(this).attr('data-cofirm__text'), $(this).attr('href'), (($(this).is('[data-confirm__class]'))?$(this).attr('data-confirm__class'):''), (($(this).is("[data-link__success]"))?$(this).attr('data-link__success'):''));
	});

	$('select').each(function(index, el) {
		if($(this).is('[data-select__selected]') && $(this).attr('data-select__selected') != '')
			$(this).find('option[value="'+$(this).attr('data-select__selected')+'"]').attr('selected', 'selected');
	});
	$(document).on('change', '.select__activator', function(event) {
		event.preventDefault();
		$.selectLoadAjax($(this));
	});
	$('.select__activator').each(function(index, el) {
		$(this).change();
	});

	$(document).on('click', '.load__ajax', function(event) {
		event.preventDefault();
		$.loadContentAjax($(this).attr('href'),$($(this).attr('data-load__content')));

		$isPagination = $(this).parents('.pagination');
		if($isPagination.length){
			$isPagination.find('li').removeClass('active');
			$(this).parent().addClass('active');
		}
	});
});

window.print = function(){
	$.printContentClear();
    window.old_print();
}
shortcut.add("Ctrl+P",function() {
	$.printContentClear();
},{
	'type':'keydown',
	'propagate':true,
	'target':document
});


$.showLoading = function(){
	$('body').css('overflow','hidden');
	$('.modal__loading').addClass('active');
}
$.hiddenLoading = function(){
	$('body').css('overflow','auto');
	$('.modal__loading').removeClass('active');
}

$.showNotify = function($title, $text, $style, $position) {
	if($style == "error"){
		$icon = "fa fa-exclamation";
	}else if($style == "warning"){
		$icon = "fa fa-warning";
	}else if($style == "success"){
		$icon = "fa fa-check";
	}else if($style == "info"){
		$icon = "fa fa-question";
	}else{
		$icon = "fa fa-circle-o";
	}
    $.notify({
        title: $title,
        text: $text,
        image: "<i class='"+$icon+"'></i>"
    }, {
        style: 'metro',
        className: $style,
        globalPosition:$position,
        showAnimation: "show",
        showDuration: 0,
        hideDuration: 0,
        autoHideDelay: 8000,
        autoHide: true,
        clickToHide: true
    });
}
$.showConfirm = function($text, $link, $link__class, $link__success){
	$.notify({
        title: 'Esta seguro?',
        text: $text+'<div class="clearfix"></div><br><a href="'+$link+'" data-link__success="'+$link__success+'" class="btn btn-sm btn-default confirm__hidden '+$link__class+'">Si</a> <a class="btn btn-sm btn-danger confirm__hidden">No</a>',
        image: "<i class='fa fa-warning'></i>"
    }, {
        style: 'metro',
        className: "cool",
        showAnimation: "show",
        showDuration: 0,
        hideDuration: 0,
        autoHideDelay: 15000,
        autoHide: true,
        clickToHide: false
    });
}

$.reload = function(){
	$('html, body').animate({
        scrollTop: 0
    }, 500);
	setTimeout(function(){
        window.location.reload();
    }, 500);
}
$.redirect = function($link){
	document.location.href = $link;
}

$.formClear = function($form){
	$form[0].reset();
	$form.find('select').each(function(index, el) {
		$option = $(this).find('option:first-child').val();
		$(this).val($option);
		$(this).change();
	});
	$('.numberletter__result').text('');
}
$.removeItem = function($item){
	$item = $($item);
	if($item.parents('table').hasClass('datatable')){
		$tableIndex = $item.parents('table').attr('data-datatable__index');
		$table = null;
		$.each($dataTables, function(index, val) {
			if(val.index == $tableIndex)
				$table = val.table;
		});

		if($table != null)
			$table.row('#'+$item.attr('id')).remove().draw( false );
	}
	else
		$item.remove();
}
$.addItemTable = function($item, $content){
	$content = $($content);
	$content.prepend($item);
}

$.printContentClear = function(){
	if($contentPrintWindow != '')
		$('.print__content__page').addClass('active');
	else
		$('.print__content__page').removeClass('active');

	$('.print__content__page').html($contentPrintWindow);

	$contentPrintWindow = '';
}
$.printContent = function($content){
	$contentPrintWindow = $content;
	window.print();
}

$.closeModalParent = function($item){
	$modal = $item.parents('.md-modal');
	$.closeModal($modal);
}
$.closeModal = function($modal){
	$modal.removeClass('md-show');
}

$.widgetClientClear = function(){
	$('#Facturas_cliente_factura').val('');
	$('.widget__client .depent__load-info').prop('disabled',true);
	$('.show-info__load__client').html('').removeClass('active error success');
}


$.sendFormAjax = function($form){
	$.showLoading();

	$form.find('.form-ajax__control__disable').prop("disabled", false);

	$formHasImage = ($form.is('[enctype]') && $form.attr('enctype') == 'multipart/form-data');
	$data = ($formHasImage)?(new FormData($form[0])):$form.serialize();
	$.ajax({
		url: $form.attr('action'),
		type: $form.attr('method'),
		dataType: 'json',
		data: $data,
		processData: ($formHasImage)?false:true,
    	contentType: ($formHasImage)?false:'application/x-www-form-urlencoded; charset=UTF-8',
	})
	.done(function($data) {
		$.showNotify($data.title, $data.message, $data.status);
		if($data.status == 'success'){
			if($form.is("[data-form__redirect]") && $form.attr('data-form__redirect') != ''){
                setTimeout(function(){
                    location.href = $form.attr('data-form__redirect')+$data.new;
                }, 1000);
            }
			else if($form.is("[data-form__success]") && $form.attr('data-form__success') != '')
				eval($form.attr('data-form__success'));
        }
	})
	.fail(function() {
		$.showNotify('Error', 'Ocurrio un error durante la conexión con el servidor. Intente mas tarde!!!', 'error');
	})
	.always(function() {
		$form.find('.form-ajax__control__disable').prop("disabled", true);
		$.hiddenLoading();
	});
}
$.linkAjax = function($link){
	$.showLoading();
	$.ajax({
		url: $link.attr('href'),
		type: 'get',
		dataType: 'json',
	})
	.done(function($data) {
		$.showNotify($data.title, $data.message, $data.status);
		if($data.status == 'success')
			if($link.is('[data-link__success]') && $link.attr('data-link__success') != '')
				eval($link.attr('data-link__success'));
	})
	.fail(function() {
		$.showNotify('Error', 'Ocurrio un error durante la conexión con el servidor. Intente mas tarde!!!', 'error');
	})
	.always(function() {
		$.hiddenLoading();
	});
}

$.loadContentAjax = function($link,$container){
	if($link != ''){
		$.showLoading();
		$.ajax({
			url: $link,
			type: 'get',
			dataType: 'json',
		})
		.done(function($data) {
			if($data.status == 'success')
				$container.html($data.result);
			else
				$.showNotify($data.title, $data.message, $data.status);
		})
		.fail(function() {
			$.showNotify('Error', 'Ocurrio un error durante la conexión con el servidor. Intente mas tarde!!!', 'error');
		})
		.always(function() {
			$.hiddenLoading();
		});
	}
}
$.selectLoadAjax = function($select){
	$($select.attr('data-select__active')).html('<option value="" selected="selected">--- Seleccione una opción ---</option>');
	$($select.attr('data-select__active')).attr('disabled','disabled');
	if($select.val() != ''){
		$.showLoading();
		$.ajax({
			url: $select.attr('data-select__ajax'),
			type: 'get',
			dataType: 'json',
			data: {id: $select.val()}
		})
		.done(function($data) {
			if($data.status == 'success'){
				$selectActive = $($select.attr('data-select__active'));
				$selectActive.html($data.result);
				$selectActive.attr('disabled',false);
				$selectActive.change();

				if($selectActive.is('[data-select__selected]') && $selectActive.attr('data-select__selected') != ''){
					$selectActive.find('option[value="'+$selectActive.attr('data-select__selected')+'"]').attr('selected', 'selected');
					$selectActive.attr('data-select__selected','');
				}

				if($select.is('[data-load__content__more]') && $select.attr('data-load__content__more') != ''){
					$dataMore = $.parseJSON($select.attr('data-load__content__more'));
					$($dataMore.container).attr($dataMore.attr,$data.valueMore);
				}
			}
			else
				$.showNotify($data.title, $data.message, $data.status);
		})
		.fail(function() {
			$.showNotify('Error', 'Ocurrio un error durante la conexión con el servidor. Intente mas tarde!!!', 'error');
		})
		.always(function() {
			$.hiddenLoading();
		});
	}
}