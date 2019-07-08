$.fn.isOnScreen = function(){
    var win = $(window);
    var viewport = {
        top : win.scrollTop(),
        left : win.scrollLeft()
    };
    viewport.right = viewport.left + win.width();
    viewport.bottom = viewport.top + win.height();

    var bounds = this.offset();
    bounds.right = bounds.left + this.outerWidth();
    bounds.bottom = bounds.top + this.outerHeight();

    return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));

};

function isValidEmail(emailText) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailText);
};

function EmptyCheckdyn(selector){
	$('.errlog').remove();
	err = 0;
	trgt = 0;	
	$(selector).each(function(){
		mssg = '';
		tis = $(this);
		inp = $(tis).children().eq(0);
		if(inp.length>0){
			if(tis.is("select")){
				inp = tis;
			}else{
				inp = inp;
			}				
		}else{
			inp = tis;
		}
		iinp = $(inp).find('input');
		if(iinp.is("input")){
			inp = iinp;
		}else{
			inp = inp;
		}
		if (inp.is("input")) {
			if($(inp).attr('type')=='radio' || $(inp).attr('type')=='checkbox'){ //Radio / Checkbox============
				nm = $(inp).attr('name');
				if($(tis).find('input[name="'+nm+'"]').length >0){
					if($(tis).find('input[name="'+nm+'"]:checked').length<=0){
						valu = '';
					}else{
						valu = 1;
					}	
				}
			}else if($(inp).attr('name')=='email' || $(inp).attr('name')=='ae_email'){
				valu = $(inp).val();
				if(valu!='' && !isValidEmail(valu)){
					//alert('Please give valid email id!');
					mssg = 'Please give valid email id!';
					err = 1;
				}				
			}else{						//Textbox============
				valu = $(inp).val();
			}
		}else if (inp.is("select")) {	//Select=============
			valu = $(inp).val();
		}else if (inp.is("textarea")) { //Textarea===========
			valu = $(inp).val();
		}
		
		if(valu==''){
			trgt++;
			err = 1;
			$(tis).css('border','1px solid red');
			$(tis).addClass('dangbar');
		}else{
			fnvl = $(tis).val().length;
			min_len = $(tis).attr('min');			
			max_len = $(tis).attr('max');
			if(fnvl<min_len && undef(max_len)==''){
				err = 1;
				mssg = 'Please give minimum length '+min_len;
			}else if(fnvl<min_len || fnvl>max_len){
				err = 1;
				mssg = 'Please give minimum '+min_len+' and maximum '+max_len+' length !';				
			}
			if(err==1 && undef(mssg)!=''){
				trgt++;
				$(tis).css('border','1px solid red');
				$(tis).addClass('dangbar');
				$(tis).after('<span class="errlog">'+mssg+'</span>');
			}else{
				$(tis).css('border','1px solid rgb(229, 229, 229)');
			}
			
		}
		if(trgt==1){ // Focust to first error from top with animation
			anitop(tis);
		}		
	});
	return err;
}

function anitop(pos){
	off = $(pos).offset();
	$("html, body").animate({ scrollTop: (off.top - 200) }, 300); 
}

function ajax_reload(load_id){
	if(load_id!=''){
		$('#'+load_id).load(window.location.href +' #'+load_id+' >*' , function(){
			//lightbox();
		});
	}
	else{
		$(window).load(window.location.href);
	}
}

function undef(cont){
	if(cont!='' && typeof cont!='undefined'){
		return cont;
	}else{return '';}
}

function blanket(){
	$('#blanket').empty();
	$('#blanket').css('display','none');
	$('#blanket').css({
		'height':'100%',
		'width':'100%'
	});
	$('#blanket').prepend('<img id="theImg" src="img/loading_front.gif" />');
	$('#blanket').css('display','block');
	$("#theImg").css({
		left: (($(window).width() - $('#theImg').width()) / 2),
		top: ($(window).width() - $('#theImg').width()) / 7,
		position:'absolute'
	});
}

function positionPopup(formid){
	setTimeout(function(){
		$(formid).css({position:'absolute'});
		if(!$(formid).is(':visible')){
			return;
		}
		$(formid).css({
			left: ($(window).width() - $(formid).width()) / 2,
			top: ($(window).width() - $(formid).width()) / 10,
		});
	},2000);
}

function slug_convert(slug,target){
	trimd = slug.trim();
	st1	= trimd.replace(/\W/g , " ");
	st2	= st1.replace(/\s+/g , "-").toLowerCase();
	$(target).val(st2);
}

function reduce_char(tis,tot,e){
	key = e.keyCode;
	input = tis.val();
	input1 = input.replace(/[^a-zA-Z ^0-9 ^.,]/g, "");
	tis.val(input1);
	cr = input1.length;
	if(cr > tot){
		str = input1.substring(0,tot);
		tis.val(str);
		if(key!=8 || key==46){
			$(tis).keydown(function() {
			  return false;
			});
		}
	}else{
		if(key==8 || key==46){
			$(tis).unbind('keydown');
		}
	}		
	if(tot-cr>0){
		return (tot-cr);
	}else{
		return 0;
	}		
}

function randomPassword(length) {
    var chars = "abcdefghijklmnopqrstuvwxyz!@#$%^&*()-+<>ABCDEFGHIJKLMNOP1234567890";
    var pass = "";
    for (var x = 0; x < length; x++) {
        var i = Math.floor(Math.random() * chars.length);
        pass += chars.charAt(i);
    }
    return pass;
}

function generate(target,len) {
    $(target).val(randomPassword(len));
}

function cm_divcentr(targets){ // Make div content vertically center
	$(targets).each(function(){
		a = 0;				
		ih = $(this).outerHeight();
		if(ih==0){
			a = $(this).children().eq(1).outerHeight();
		}else{
			a = ih;
		}
		
		p = $(this).parent().height();					
		if(p==0){
			p = $(this).parents().eq(1).outerHeight();
		}
		d = (p - a);					
		ht = (p/2) - (a/2);
		$(this).css('top',ht);
	});
}

function Confirm(title, msg, $true, $false, $link) {
	if(undef($true)!=''){
		$true = "<button class='button button-danger doAction'>" + $true + "</button>";
	}else{$true = '';}
	
	var $content =  "<div class='dialog-ovelay'>" +
					"<div class='dialog'><header>" +
					 " <h3> " + title + " </h3> " +
					 "<i class='fa fa-close'></i>" +
				 "</header>" +
				 "<div class='dialog-msg'>" +
					 " <p> " + msg + " </p> " +
				 "</div>" +
				 "<footer>" +
					 "<div class='controls'>" +
						 $true +
						 " <button class='button button-default cancelAction'>" + $false + "</button> " +
					 "</div>" +
				 "</footer>" +
			  "</div>" +
			"</div>";
	$('body').prepend($content);
	$('.dialog-ovelay').fadeIn();
	$('.doAction').click(function () {
		//window.open($link, "_blank"); /*new*/
		window.location.href = undef($link);
	});
	$('.cancelAction, .fa-close').click(function () {
		//window.location.href = '';
		$(this).parents('.dialog-ovelay').fadeOut(500, function () {
			$(this).remove();
		});
	});
}

function validnumber(tis,numbers,tot){
	max = 0;
	nbr = numbers.replace(/[^0-9]/g, "");
	cr = nbr.length;
	if(cr > tot){
		nbr = nbr.substring(0,tot);
		max = 1;
	}
	if(max>0){
		$(tis).next().remove();
		$(tis).after('<span class="errlog">Max Limit '+tot+' Digits!</span>');
		$(tis).css('border','1px solid red');
		$(tis).val(nbr);
		return false;
	}
	$(tis).val(nbr);
}

function formatDate(date) {
	var d = new Date(date),
	month = '' + (d.getMonth() + 1),
	day = '' + d.getDate(),
	year = d.getFullYear();

	if (month.length < 2) month = '0' + month;
	if (day.length < 2) day = '0' + day;

	return [day, month, year].join('-');
}

function WOverlay(target,inner){
	$('.WOverlay').remove();
	if(undef(target)!=''){
		$(target).before('<div class="WOverlay"></div>');
		if(undef(inner)!=''){
			$('.WOverlay').css({'position':'absolute','z-index': 999});
		}
	}
}

function notify(msg,st){
	$.notify({
		message: msg,
		status: st,
		onClose: function(){
			window.location.href=window.location.href;
		}
	});
}