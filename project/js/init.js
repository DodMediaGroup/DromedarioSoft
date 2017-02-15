var w;
var h;
var dw;
var dh;

function executeFunctionByName(functionName, context /*, args */) {
  var args = [].slice.call(arguments).splice(2);
  var namespaces = functionName.split(".");
  var func = namespaces.pop();
  for(var i = 0; i < namespaces.length; i++) {
    context = context[namespaces[i]];
  }
  return context[func].apply(this, args);
}

var changeptype = function(){
    w = $(window).width();
    h = $(window).height();
    dw = $(document).width();
    dh = $(document).height();

    if(jQuery.browser.mobile === true){
      	$("body").addClass("mobile").removeClass("fixed-left");
    }

    if(!$("#wrapper").hasClass("forced")){
	    if(w > 990){
	    	$("body").removeClass("smallscreen").addClass("widescreen");
	      $("#wrapper").removeClass("enlarged");
	    }else{
	    	$("body").removeClass("widescreen").addClass("smallscreen");
	    	$("#wrapper").addClass("enlarged");
	    }
	}
	toggle_slimscroll(".slimscrollleft");
}

$(document).ready(function(){
	FastClick.attach(document.body);
	resizefunc.push("initscrolls");
	resizefunc.push("changeptype");
	$('.sparkline').sparkline('html', { enableTagOptions: true });

	$('.animate-number').each(function(){
		$(this).animateNumbers($(this).attr("data-value"), true, parseInt($(this).attr("data-duration"))); 
	})

//TOOLTIP
$('body').tooltip({
  selector: "[data-toggle=tooltip]",
  container: "body"
});

//RESPONSIVE SIDEBAR


$(".open-right").click(function(e){
  $("#wrapper").toggleClass("open-right-sidebar");
  e.stopPropagation();
  $("body").trigger("resize");
});


$(".open-left").click(function(e){
	e.stopPropagation();
    $("#wrapper").toggleClass("enlarged");
    $("#wrapper").addClass("forced");
    $(".left ul").removeAttr("style");
    toggle_slimscroll(".slimscrollleft");
    $("body").trigger("resize");
});

// LEFT SIDE MAIN NAVIGATION
$("#sidebar-menu a").on('click',function(e){
  if(!$("#wrapper").hasClass("enlarged")){

    if($(this).parent().hasClass("has_sub")) {
      e.preventDefault();
    }   

    if(!$(this).hasClass("subdrop")) {
      // hide any open menus and remove all other classes
      $("ul",$(this).parents("ul:first")).slideUp(350);
      $("a",$(this).parents("ul:first")).removeClass("subdrop");
      $("#sidebar-menu .pull-right i").removeClass("fa-angle-up").addClass("fa-angle-down");
      
      // open our new menu and add the open class
      $(this).next("ul").slideDown(350);
      $(this).addClass("subdrop");
      $(".pull-right i",$(this).parents(".has_sub:last")).removeClass("fa-angle-down").addClass("fa-angle-up");
      $(".pull-right i",$(this).siblings("ul")).removeClass("fa-angle-up").addClass("fa-angle-down");
    }else if($(this).hasClass("subdrop")) {
      $(this).removeClass("subdrop");
      $(this).next("ul").slideUp(350);
      $(".pull-right i",$(this).parent()).removeClass("fa-angle-up").addClass("fa-angle-down");
      //$(".pull-right i",$(this).parents("ul:eq(1)")).removeClass("fa-chevron-down").addClass("fa-chevron-left");
    }
  } 
});

// NAVIGATION HIGHLIGHT & OPEN PARENT
$("#sidebar-menu ul a.active").parents("li:last").children("a:first").addClass("active").trigger("click");

//WIDGET ACTIONS
$(".widget-header .widget-close").on("click",function(){
  $item = $(this).parents(".widget:first");
  bootbox.confirm("Are you sure to remove this widget?", function(result) {
    if(result === true){
      $item.addClass("animated bounceOutUp");
        window.setTimeout(function () {
           $item.remove();
        }, 300);
    }
  }); 
});

//WIDGET CALENDAR

monthNames = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
dayNames = ["Lun", "Mar", "Mie", "Jue", "Vie", "Sab", "Dom"];

var cTime = new Date(), month = cTime.getMonth()+1, year = cTime.getFullYear();
var events = [
  /*{
    "date": "7/"+month+"/"+year, 
    "title": 'Kick off meeting!', 
    "link": 'javascript:;', 
    "color": 'rgba(255,255,255,0.2)', 
    "content": 'Have a kick off meeting with .inc company'
  },
  {
    "date": "19/"+month+"/"+year, 
    "title": 'Link to Google', 
    "link": 'http://www.google.com', 
    "color": 'rgba(255,255,255,0.2)', 
  }*/
];
$('#widget__calendar').bic_calendar({
    events: events,
    dayNames: dayNames,
    monthNames: monthNames,
    showDays: true,
    displayMonthController: true,
    displayYearController: false,
    popoverOptions:{
        placement: 'top',
        trigger: 'hover',
        html: true
    },
    tooltipOptions:{
        placement: 'top',
        html: true
    }
});

//END WIDGET CALENDAR


$(document).on("click", ".widget-header .widget-toggle", function(event){
  event.preventDefault();
  $(this).toggleClass("closed").parents(".widget:first").find(">.widget-content").slideToggle();
});
$('.widget-header .widget-toggle.toggle__active').click();

$(document).on("click", ".widget-header .widget-popout", function(event){
  event.preventDefault();
  var widget = $(this).parents(".widget:first");
  if(widget.hasClass("modal-widget")){
    $("i",this).removeClass("icon-window").addClass("icon-publish");
    widget.removeAttr("style").removeClass("modal-widget");
    widget.find(".widget-maximize,.widget-toggle").removeClass("nevershow");
    widget.draggable("destroy").resizable("destroy");
  }else{
    widget.removeClass("maximized");
    widget.find(".widget-maximize,.widget-toggle").addClass("nevershow");
    $("i",this).removeClass("icon-publish").addClass("icon-window");
    var w = widget.width();
    var h = widget.height();
    widget.addClass("modal-widget").removeAttr("style").width(w).height(h);
    $(widget).draggable({ handle: ".widget-header",containment: ".content-page" }).css({"left":widget.position().left-2,"top":widget.position().top-2}).resizable({minHeight: 150,minWidth: 200});
  }
  $("body").trigger("resize");
});

$(document).on("click", ".widget", function(){
    if($(this).hasClass("modal-widget")){
      $(".modal-widget").css("z-index",5);
      $(this).css("z-index",6);
    }
});

$(document).on("click", '.widget .reload', function (event) { 
  event.preventDefault();
  var el = $(this).parents(".widget:first");
  blockUI(el);
    window.setTimeout(function () {
       unblockUI(el);
    }, 1000);
});

$(document).on("click", ".widget-header .widget-maximize", function(event){
    event.preventDefault();
    $(this).parents(".widget:first").removeAttr("style").toggleClass("maximized");
    $("i",this).toggleClass("icon-resize-full-1").toggleClass("icon-resize-small-1");
    $(this).parents(".widget:first").find(".widget-toggle").toggleClass("nevershow");
    $("body").trigger("resize");
    return false;
});

$( ".portlets" ).sortable({
    connectWith: ".portlets",
    handle: ".widget-header",
    cancel: ".modal-widget",
    opacity: 0.5,
    dropOnEmpty: true,
    forcePlaceholderSize: true,
    receive: function(event, ui) {$("body").trigger("resize")}
});

// Init Code Highlighter
prettyPrint();

//RUN RESIZE ITEMS
$(window).resize(debounce(resizeitems,100));
$("body").trigger("resize");

//SELECT
$('.selectpicker').selectpicker();


//FILE INPUT
$('input[type=file]').bootstrapFileInput();


//DATE PICKER
$dataPicker__inputs = [];
$nowTemp = new Date();
$('.datepicker-input').each(function(index, el) {
  if(!$(this).is('[date-datepicker__index]')){
    $(this).attr('date-datepicker__index',index);

    $now = new Date($nowTemp.getFullYear(), $nowTemp.getMonth(), $nowTemp.getDate(), 0, 0, 0, 0);
    if($(this).is('[data-date__now]')){
      $dateNow = $(this).attr('data-date__now').split("-");
      $now = new Date($dateNow[0], ($dateNow[1]-1), $dateNow[2], 0, 0, 0, 0);
    }

    $inputText = $(this);
    $dateInput = $inputText.datepicker({
      onRender: function(date) {
        if ($(this)[0].element.attr('data-date__disabled')){
          if($(this)[0].element.attr('data-date__disabled') == 'higher')
            return (date.valueOf() > $now.valueOf()) ? 'disabled' : '';
          else if($(this)[0].element.attr('data-date__disabled') == 'minor')
            return (date.valueOf() < $now.valueOf()) ? 'disabled' : '';
        }
      }
    }).on('changeDate', function(ev) {
      if($inputText.is('[date-datepicker__activate]') && $inputText.attr('date-datepicker__activate') != ''){
        $datepickerAct = $($inputText.attr('date-datepicker__activate'));

        $.each($dataPicker__inputs, function(index, val) {
          if(val.index == $datepickerAct.attr('date-datepicker__index')){
            checkout = val.datepicker;
            
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 1);
            checkout.setValue(newDate);
          }
        });

        $datepickerAct[0].focus();
      }
      
      $thisInput = $(this);
      $.each($dataPicker__inputs, function(index, val) {
        if(val.index == $thisInput.attr('date-datepicker__index')){
          val.datepicker.hide();
        }
      });
    }).data('datepicker');
    
    if($inputText.is('[date-datepicker__assign-date]') && $inputText.attr('date-datepicker__assign-date'))
      $dateInput.setValue($inputText.attr('date-datepicker__assign-date'));
    else
      $dateInput.setValue($now);

    if($inputText.is('[date-datepicker__activate]') && $inputText.attr('date-datepicker__activate') != ''){
      $datepickerAct = $($inputText.attr('date-datepicker__activate'));
      $dateInputAct = $datepickerAct.datepicker({
        onRender: function(date){
          if ($datepickerAct.is('[data-date__disabled]')){
            if($(this)[0].element.attr('data-date__disabled') == 'higher')
              return date.valueOf() > $dateInput.date.valueOf() ? 'disabled' : '';
            else if($(this)[0].element.attr('data-date__disabled') == 'minor')
              return date.valueOf() < $dateInput.date.valueOf() ? 'disabled' : '';
          }
        }
      }).on('changeDate', function(ev) {
        $dateInputAct.hide();
      }).data('datepicker');


      if($datepickerAct.is('[data-date__now]')){
        $dateNow = $datepickerAct.attr('data-date__now').split("-");
        $now = new Date($dateNow[0], ($dateNow[1]-1), $dateNow[2], 0, 0, 0, 0);
      }
      if($datepickerAct.is('[date-datepicker__assign-date]') && $datepickerAct.attr('date-datepicker__assign-date'))
        $dateInputAct.setValue($datepickerAct.attr('date-datepicker__assign-date'));
      else
        $dateInputAct.setValue($now);

      $datepickerAct.attr('date-datepicker__index',(index+'_'+'1'));
      $dataPicker__inputs.push({
        'index': index+'_'+'1',
        'datepicker': $dateInputAct
      });
    }

    $dataPicker__inputs.push({
      'index': index,
      'datepicker': $dateInput
    });
  }
});

//AUTOCOMPLETE
$('.input__autocomplete').on('keydown', function(event) {
  var input = $($(this).attr('data-autocomplete__input'));
  input.val('');
});
$('.input__autocomplete').each(function(index, el) {
  var input = $($(this).attr('data-autocomplete__input'));
  var dataUrl = $(this).attr('data-autocomplete__data');

  $(this).autocomplete({
    source: function(request, response){
      $.ajax({
        url: dataUrl,
        dataType: "json",
        data: {
          term: request.term
        },
        success: function(data) {
          response(data);
        }
      });
    },
    minLength: 2,
    select: function(event, ui) {
      //console.log( "Selected: " + ui.item.value + " aka " + ui.item.id );
      input.val(ui.item.id);
    }
  });
});

//ICHECK
$('input:not(.ios-switch)').iCheck({
  checkboxClass: 'icheckbox_square-aero',
  radioClass: 'iradio_square-aero',
  increaseArea: '20%' // optional
});

// IOS7 SWITCH
$(".ios-switch").each(function(){
    mySwitch = new Switch(this);
});

//GALLERY
$('.gallery-wrap').each(function() { // the containers for all your galleries
    $(this).magnificPopup({
        delegate: 'a.zooming', // the selector for gallery item
        type: 'image',
    		removalDelay: 300,
    		mainClass: 'mfp-fade',
        gallery: {
          enabled:true
        }
    });
}); 

// VALIDAR CAMPOS SOLO NUMERICOS
$(document).on('keypress', '.js-input-number', function(event){
    if(!((event.which <= 57 && event.which >= 48) || event.which == 8))
        event.preventDefault();
});
$(document).on('focus', '.input__reset', function(event) {
  event.preventDefault();
  if($(this).val() == 0)
    $(this).val('');
});
$(document).on('blur', '.input__reset', function(event) {
  event.preventDefault();
  if($(this).hasClass('js-input-number') && $(this).val() == '')
    $(this).val('0');
});


// MOSTRAR IMAGEN ANTES DE SER CARGADA
$('.js-show-before').on('change', function(){
  $.readBeforeFile(this);
});

//NumbersToLetters
$(document).on('keyup', '.numbertoletter', function(event) {
  event.preventDefault();
  if($(this).is('[data-numberto__result]') && $(this).attr('data-numberto__result') != ''){
    $numberLetter = NumbersToLetters($(this).val());
    $($(this).attr('data-numberto__result')).text($numberLetter);
  }
});

});

var debounce = function(func, wait, immediate) {
  var timeout, result;
  return function() {
    var context = this, args = arguments;
    var later = function() {
      timeout = null;
      if (!immediate) result = func.apply(context, args);
    };
    var callNow = immediate && !timeout;
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
    if (callNow) result = func.apply(context, args);
    return result;
  };
}

function resizeitems(){
  if($.isArray(resizefunc)){  
    for (i = 0; i < resizefunc.length; i++) {
        window[resizefunc[i]]();
    }
  }
}

function initscrolls(){
    if(jQuery.browser.mobile !== true){
	    //SLIM SCROLL
	    $('.slimscroller').slimscroll({
	      height: 'auto',
	      size: "5px"
	    });

	    $('.slimscrollleft').slimScroll({
	        height: 'auto',
	        position: 'left',
	        size: "5px",
	        color: '#7A868F'
	    });
	}
}
function toggle_slimscroll(item){
    if($("#wrapper").hasClass("enlarged")){
      $(item).css("overflow","inherit").parent().css("overflow","inherit");
      $(item). siblings(".slimScrollBar").css("visibility","hidden");
    }else{
      $(item).css("overflow","hidden").parent().css("overflow","hidden");
      $(item). siblings(".slimScrollBar").css("visibility","visible");
    }
}

function nifty_modal_alert(effect,header,text){
    
    var randLetter = String.fromCharCode(65 + Math.floor(Math.random() * 26));
    var uniqid = randLetter + Date.now();

    $modal =  '<div class="md-modal md-effect-'+effect+'" id="'+uniqid+'">';
    $modal +=    '<div class="md-content">';
    $modal +=      '<h3>'+header+'</h3>';
    $modal +=      '<div class="md-modal-body">'+text;
    $modal +=      '</div>';
    $modal +=    '</div>';
    $modal +=  '</div>';

    $("body").prepend($modal);

    window.setTimeout(function () {
        $("#"+uniqid).addClass("md-show");
        $(".md-overlay,.md-close").click(function(){
          $("#"+uniqid).removeClass("md-show");
          window.setTimeout(function () {$("#"+uniqid).remove();},500);
        });
    },100);

    return false;
}

function blockUI(item) {    
    $(item).block({
      message: '<div class="loading"></div>',
      css: {
          border: 'none',
          width: '14px',
          backgroundColor: 'none'
      },
      overlayCSS: {
          backgroundColor: '#fff',
          opacity: 0.4,
          cursor: 'wait'
      }
    });
}

function unblockUI(item) {
    $(item).unblock();
}

function toggle_fullscreen(){
    var fullscreenEnabled = document.fullscreenEnabled || document.mozFullScreenEnabled || document.webkitFullscreenEnabled;
    if(fullscreenEnabled){
      if(!document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) {
          launchIntoFullscreen(document.documentElement);
      }else{
          exitFullscreen();
      }
    }
}


// Thanks to http://davidwalsh.name/fullscreen

function launchIntoFullscreen(element) {
  if(element.requestFullscreen) {
    element.requestFullscreen();
  } else if(element.mozRequestFullScreen) {
    element.mozRequestFullScreen();
  } else if(element.webkitRequestFullscreen) {
    element.webkitRequestFullscreen();
  } else if(element.msRequestFullscreen) {
    element.msRequestFullscreen();
  }
}

function exitFullscreen() {
  if(document.exitFullscreen) {
    document.exitFullscreen();
  } else if(document.mozCancelFullScreen) {
    document.mozCancelFullScreen();
  } else if(document.webkitExitFullscreen) {
    document.webkitExitFullscreen();
  }
}




$.readBeforeFile = function(input){
  var content = input.getAttribute('data-before');
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $(content).html('');
      $(content).append($('<div>', {
        class:"img"
      }).css('background-image', 'url('+e.target.result+')'));
    }
    reader.readAsDataURL(input.files[0]);
  }
}

$.isset = function($data){
  if(typeof $data == "undefined" || $data == null)
    return false
  else
    return true
}