// JavaScript Document


$(document).ready(function(e) {
	

	var lheader = $('.login-header').innerHeight();
	var lfooter = $('.copy-right').innerHeight();
	var ltotal = lheader + lfooter;
	
	$(window).load(function(){ // On load
		$('.login-contain').css({'height':(($(window).height() - ltotal ))+'px'});
	});
	$(window).resize(function(){ // On resize
		$('.login-contain').css({'height':(($(window).height() - ltotal ))+'px'});
		

	
	}); 

	/**  Filter **/
		$('.filter-toggleslide').hide();
		$('.filter-toggle').click(function(){
			$(this).toggleClass('show')
			$('.filter-toggleslide').slideToggle(300);
		})
			
		/*$('.timepicker').datetimepicker({
			datepicker:false,
			format:'H:m a',	
		});*/
		/*$('.daypicker').datetimepicker({
			timepicker:false,
			format:'l',	
		});*/
		
		
		 $("#tabs").tabs();
		 $('.timepicker').wickedpicker();
		 $("#workouttabs").tabs();
		 $("#yourworkout_tabs").tabs();
		 $("#timertabs").tabs();
		
	/**  End Filter **/
	
	
	
	
	/******  Select Box  *******/
	$('select').select2();
	
	/*****  File upload ******/
	
	$("#filer_input").filer({
        maxSize: 4,
        extensions: null,
        showThumbs: true,
        templates: {
            box: '<ul class="jFiler-items-list jFiler-items-grid"></ul>',
            item: '<li class="jFiler-item">\
                        <div class="jFiler-item-container">\
                            <div class="jFiler-item-inner">\
                                <div class="jFiler-item-thumb">\
                                    <div class="jFiler-item-status"></div>\
                                    <div class="jFiler-item-info">\
                                        <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
                                        <span class="jFiler-item-others">{{fi-size2}}</span>\
                                    </div>\
                                    {{fi-image}}\
                                </div>\
								<div><a class="icon-jfi-trash jFiler-item-trash-action remove-upload"></a></div>\
                            </div>\
                        </div>\
                    </li>',
            itemAppend: '<li class="jFiler-item">\
                            <div class="jFiler-item-container">\
                                <div class="jFiler-item-inner">\
                                    <div class="jFiler-item-thumb">\
                                        <div class="jFiler-item-status"></div>\
                                        <div class="jFiler-item-info">\
                                            <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
                                            <span class="jFiler-item-others">{{fi-size2}}</span>\
                                        </div>\
                                        {{fi-image}}\
                                    </div>\
									<div><a class="icon-jfi-trash jFiler-item-trash-action"></a></div>\
                                </div>\
                            </div>\
                        </li>',
            progressBar: '<div class="bar"></div>',
            itemAppendToEnd: false,
            removeConfirmation: true,
            _selectors: {
                list: '.jFiler-items-list',
                item: '.jFiler-item',
                progressBar: '.bar',
                remove: '.jFiler-item-trash-action'
            }
        },
        captions: {
            button: "Choose Files",
            feedback: "Choose Files To Upload",
            feedback2: "files were chosen",
            drop: "Drop file here to Upload",
            removeConfirmation: "Are you sure you want to remove this file?",
            errors: {
                filesLimit: "Only {{fi-limit}} files are allowed to be uploaded.",
                filesType: "Only Images are allowed to be uploaded.",
                filesSize: "{{fi-name}} is too large! Please upload file up to {{fi-maxSize}} MB.",
                filesSizeAll: "Files you've choosed are too large! Please upload files up to {{fi-maxSize}} MB."
            }
        }
    });
	

});

$(document).ready(function(e) {

	var header = $('.header').innerHeight();
	var footer = $('.copy-right').innerHeight();
	var nav = $('.nav').innerHeight();
	var total = header + footer + nav;
	
	$(window).load(function(){ // On load
		$('.main-content').css({'height':(($(window).height() - total ))+'px'});
	});
	$(window).resize(function(){ // On resize
		$('.main-content').css({'height':(($(window).height() - total ))+'px'});
		/******  Select Box  *******/
		$('select').select2();		
	}); 

}); 

$(document).ready(function(e) {
	
	/* Custome Popup */	
	
	$('.cust-popup').click(function(){
		var id =  $(this).attr('href');
		$(id).css('display', 'block');
		
		$('.bodyclose').click(function(){
			$(id).css('display', 'none');
		});
	});
	
	/* End Custome Popup */
	
	
	/* Floating Input */
	
	$('.frm-control').on('focus blur', function (e) {
		$(this).parents('.frm-group').toggleClass('focused', (e.type === 'focus' || this.value.length > 0));
	}).trigger('blur');
	
	/* End Floating Input */
	
	
	$(".select-control, .no-search").select2({
		minimumResultsForSearch: -1,
	});
	
	
	/*$('.acrodian-content').hide(); 
	 $(".acrodian-title").click(function(){
	 
		if(false == $(this).next().is(':visible')) {
			$('.acrodian-content').slideUp(800);
			$(".acrodian-title").removeClass('active');
		}
		$(this).next().slideToggle(800);
		$(this).toggleClass('active');
		
	});
	var x = 0;
	$('.acrodian-content').eq(x).show();
	$('.acrodian-content').eq(x).show().parent('.workOut-acrodian').children('.acrodian-title').addClass('active');*/
	
	// accordian scripts	
	$('.acrodian-content').hide(); 
	$(".acrodian-title").click(function(){
	 
		if(false == $(this).next().is(':visible')) {
			$('.acrodian-content').slideUp(800);
			$(".acrodian-title").removeClass('active');
		}
		$(this).next().slideToggle(800);
		$(this).toggleClass('active');
		
	});
	/*var x = 0;
	$('.acrodian-content').eq(x).show();
	$('.acrodian-content').eq(x).show().parent('.workOut-acrodian').children('.acrodian-title').addClass('active');*/
	
	
	$(".valid-input").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
		 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			//display error message
			return false;
		}
	});
	$(".valid-input").on('input',function () {
		if($(this).val().length == $(this).attr('maxlength')) {
			$(this).parent('.timer-input-small').next('.timer-input-small').find("input").focus();
		}
	});
	$(".valid-input").on('input',function () {
		if($(this).val().length == $(this).attr('maxlength')) {
			$(this).parent('.timer-box').parent('li').next('li').find("input").focus();
		}
	});
	$(".valid-input").on('input',function () {
		if($(this).val().length == $(this).attr('maxlength')) {
			$(this).parent('.timer-box').parent('div').next('div').find("input").focus();
		}
	});
	
	/*var parameterfieldHTML = '<div class="form-group"><div class="addrow removerow"><a href="javascript:void(0);"><i class="fa fa-times"></i></a></div><div class="parameter-input"><input type="text" class="form-control" placeholder="Enter parameter"></div></div>'; 
	
	
	
	var str = 'other';
	$("select.select-parameter").change(function () {
		if( $(this).val() == str){
			$( "#addparameter" ).append(parameterfieldHTML);		
			$( "#addparameter2" ).append(parameterfieldHTML);		
		}
		else{
			$( "#addparameter .form-group" ).remove();		
			$( "#addparameter2 .form-group" ).remove();		
		}
	});*/
	
	  
	$(window).load(function(){
		$(".unitlisting").mCustomScrollbar();
	});
	
	
	$('#addunit').click(function(e) {
    	$("#showunit").append(unitfieldHTML);		    
    });
	
	$(function() {
		$(".timer-bottomlist").sortable();
		$('.edit-toggle').click(function(e) {
		  $(this).parent('.timer-edit').toggleClass('show');
		  $(this).parent('.timer-edit').find('.timer-container').slideToggle();  
		});
	});
	
});

