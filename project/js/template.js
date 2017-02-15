$(document).ready(function(){
	$.fn.editable.defaults.mode = 'inline';
	$(".todo-list").sortable({
		cancel: ".done",
		axis: "y",
		cursor: "move",
		forcePlaceholderSize: true
	});

	$(document).on("ifChecked", ".check-icon input", function(){
		var parent = $(this).parents("li:first");
		$(parent).addClass("done");
		$(parent).data("orig-order",$(parent).index()).insertAfter($(".todo-list li:last"));
		$('.todo-item',parent).editable("toggleDisabled");
	});

	$(document).on("ifUnchecked", ".check-icon input", function(){
		var parent = $(this).parents("li:first");
		$(parent).removeClass("done");
		if($(parent).data("orig-order")){
			$(parent).insertAfter($(".todo-list li:eq("+($(parent).data("orig-order")-1)+")"));
		}
		$('.todo-item',parent).editable("toggleDisabled");
	});

	$(document).on("click",".add-todo", function(){
		var $item = '<li class="animated bounceInDown">'+
						'<span class="check-icon"><input type="checkbox" /></span>'+
						'<span class="todo-item">New item</span>'+
						'<span class="todo-options pull-right">'+
							'<a href="javascript:;" class="todo-delete"><i class="icon-cancel-3"></i></a>'+
						'</span>'+
					'</li>';
		$(".todo-list").append($item);
		
		$('input').iCheck({
		  checkboxClass: 'icheckbox_square-aero',
		  radioClass: 'iradio_square-aero',
		  increaseArea: '20%'
		});

		$('.todo-list .todo-item').editable({
		    type: 'text'
	    });
	    window.setTimeout(function () {
		   	$(".todo-list li").removeClass("animated");
		}, 500);
	});

	$(document).on("click", ".todo-delete", function(){
		var parent = $(this).parents("li:first");
		$(parent).hide(200);
	})

	var $contextMenu = $("#contextMenu");
    var $rowClicked;

    $(document).on("contextmenu", ".todo-list li", function (e) {
        $rowClicked = $(this)
        $contextMenu.css({
            display: "block",
            left: e.pageX,
            top: e.pageY
        });
        return false;
    });

    $contextMenu.on("click", "a", function () {
        $rowClicked.removeAttr("class").addClass($(this).data("priority"));
        $contextMenu.hide();
    });

    $(document).click(function () {
        $contextMenu.hide();
    });

	$('.todo-list .todo-item').editable({
	    type: 'text'
    });



	$dataTables = [];
	$('.datatable').each(function(index, el) {
		$table = $(this).DataTable();
		$(this).attr('data-datatable__index',index);
	    
	    if($(this).is('[data-datatable__filter]') && $(this).attr('data-datatable__filter') == '1'){
		    $(this).find("tfoot th").each( function ( i ) {
		        var select = $('<select class="form-control input-sm"><option value=""></option></select>')
		            .appendTo( $(this).empty() )
		            .on( 'change', function () {
		                $table.column( i )
		                    .search( '^'+$(this).val()+'$', true, false )
		                    .draw();
		            });

		        $table.column( i ).data().unique().sort().each( function ( d, j ) {
		            select.append( '<option value="'+d+'">'+d+'</option>' )
		        });
		    });
	    }

	    $dataTables.push({
	    	'index': index,
	    	'table': $table
	    });
	});


	$('[duplicate__block]').on('click', function(event) {
		event.preventDefault();
		$element = $($(this).attr('duplicate__block')).last();
		$newElement = $element.clone();

		$newElement.find('input').val('');

		$element.after($newElement);
	});
});


$(function(){
	//listen for click events from this style
	$(document).on('click', '.notifyjs-metro-base .confirm__hidden', function() {
		$(this).trigger('notify-hide');
	});
});

$.checkedInput = function($input){
	$input.prop("checked", true).parent('.icheckbox_square-aero').addClass('checked');
}
$.unCheckedInput = function($input){
	$input.prop("checked", false).parent('.icheckbox_square-aero').removeClass('checked');
}
$.checkedInputDisabled = function($input){
	$input.prop("disabled", true).parent('.icheckbox_square-aero').addClass('disabled');
}
$.unCheckedInputDisabled = function($input){
	$input.prop("disabled", false).parent('.icheckbox_square-aero').removeClass('disabled');
}


var $contentPrintWindow = '';
window.old_print = window.print;