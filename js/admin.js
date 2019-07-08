jQuery(document).ready(function($){
		
	$('.empval').live('click',function(){
		$(this).css('border','1px solid #ccc');
		$(this).next('.err').remove();
	});	
	
	$('#sel_catg').live('click',function(){
		$.ajax({
			url: "ad_ajax.php",
			type: "POST",
			data: 'getcatg=on',
			success: function(data){
				$('#append_catg').empty();
				$('#append_catg').append(data);
				$('#catgclk').click();
			}
		});					
	});
	
	$('.slider').live('click', function(){
		ids = $(this).prev().attr('rel');
		if($(this).prev().prop("checked") == true){
			st = 0;
		}else{
			st = 1;
		}
		$.ajax({
			url: "ad_ajax.php",
			type: "POST",
			data: 'postaproval='+st+'&post='+ids,
			success: function(data){}
		});
	});
	
	$('.postview').live('click', function(){
		ids = $(this).attr('rel');
		$.ajax({
			url: "ad_ajax.php",
			type: "POST",
			data: 'postview='+ids,
			success: function(data){
				$('#append_post').empty();
				$('#append_post').append(data);
				$('#postclk').click();
			}
		});
	});
	
	$("#page_form").bind('submit', function(e) {
		blanket();
		e.preventDefault();
		$('.empval').css('border','1px solid grey');
		if(EmptyCheckdyn('.empval')==1){
			$.notify('Focussed Fields are required!', 'danger');
			return false;
		}else{
			for (instance in CKEDITOR.instances) {
				CKEDITOR.instances[instance].updateElement();
			}			
			$.ajax({
				url: "ad_ajax.php",
				type: "POST",
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData:false,
				success: function(data){
					if(data!=1){
						$.notify(data, 'danger');
					}else{
						mval = $('#pagesubmit').attr('name');
						if(mval=='pageupdate'){
							$.notify('Successfully Updated!.', 'success');
						}else{
							$.notify('Successfully Created!.', 'success');
						}
					}
					$("#page_form").get(0).reset();
					setTimeout(function(){
						window.location.href='pages.php';
					},3000);
				}
			});
		}
	});
	
	// Common Views ========================================
	$('.views').live('click', function (){
		slg = $(this).attr('rel'); // Slug
		actn = 'view';	
		ids = $(this).parents().eq(1).attr('rel');
		base = window.location.origin;
		pageurl = window.location.pathname;
		window.location.href=base+pageurl+'?action='+actn+'&'+slg+'='+ids;
	});
	
	// Common Edits ========================================
	$('.edits').live('click', function (){
		page = '';
		slg = $(this).attr('rel'); // Slug
		if(slg=='catg'){
			actn = 'editcat';
		}else{
			actn = 'edit';
		}		
		ids = $(this).parents().eq(1).attr('rel');
		base = window.location.origin;
		pageurl = window.location.pathname;
		window.location.href=base+pageurl+'?action='+actn+'&'+slg+'='+ids+page;
	});
	
	// Common Deletes ========================================
	$('.deletes').live('click', function (){
		slg = $(this).attr('rel'); // Slug
		slug=fil='';
		if(slg=='page'){
			post = 'pagedel';
			relod = 'page-load';		
		}else if(slg=='user'){
			post = 'userdel';
			relod = 'user-load';
		}else if(slg=='catg' || slg=='catg_prnt' || slg=='catg_chld'){
			slug = '&slug='+slg;
			post = 'catdel';
			relod = 'catg-list';		
		}else if(slg=='glry'){
			slug = '&slug='+slg;
			post = 'galdel';
			relod = 'galry-load';
		}
		rd = $(this).attr('alt');
		ids = $(this).parents().eq(1).attr('rel');
		r = confirm("Confirm to delete this Record!");
		if(ids!='' && r == true){
			$.ajax({
				type: "post",
				url: 'call_ajax',
				data: post+'='+ids+fil,
				success: function(data){					
					if(data==1){						
						msg = 'Successfully Deleted!';
						st = 'success';						
					}else{
						msg = data;
						st = 'danger';
					}
					notify(msg,st,undef(rd));
				}
			});
		}
		
	});	
		
	function notify(msg,st,rd=''){
		$.notify({
			message: msg,
			status: st,
			onClose: function(){
				if(rd==''){
					window.location.href=window.location.href;
				}else{
					window.location.href=rd;
				}
			}
		});
	}
	
	$('#list1 li div .arow').toggle(function(){
		
		p = $(this).parents().eq(0).position();
		
		if(p.left!='' && p.left==45){
			setTimeout(function(){
				$(this).parents().eq(0).animate({left:30},function(){
				});
			},500);			
		}else{
			clk = $(this);
			$(this).parents().eq(0).animate({left:30},function(){
				tot = $('#mtot').val();
				p_id='';
				for(i=0; i<tot; i++){
					p = $(clk).parents().eq(1).prevAll().eq(i).attr('cat');
					if(p=='p'){
						p_id = $(clk).parents().eq(1).prevAll().eq(i).attr('rel');
						
						c_id = $(clk).parents().eq(1).attr('rel');
						$(clk).parents().eq(1).attr('rel',p_id+'-'+c_id);
						break;
					}
				}
				
				for(i=0; i<tot; i++){
					c = $(clk).parents().eq(1).nextAll().eq(i).attr('cat');
					if(c=='c'){
						cc_id = $(clk).parents().eq(1).nextAll().eq(i).attr('rel');
						sp = cc_id.split('-');
						$(clk).parents().eq(1).nextAll().eq(i).attr('rel',p_id+'-'+undef(sp[1]));
					}else if(c=='p'){
						break;
					}
				}
			});
			$(this).toggleClass('fa-chevron-right fa-chevron-left');
			$(this).parents().eq(1).attr('cat','c');
		}
	},function(){
		tot = $('#mtot').val();
		clk = $(this);
		p = $(this).parents().eq(0).position();
		
		if(p.left!='' && p.left==15){
			setTimeout(function(){
				$(this).parents().eq(0).animate({left:0},function(){
					rel = $(clk).parents().eq(1).attr('rel');
					r = rel.split('-');
					$(clk).parents().eq(1).attr('rel',r[1]);
				});
				$(this).toggleClass('fa-chevron-right fa-chevron-left');
			},500);			
		}else{
			$(this).parents().eq(0).animate({left:0},function(){
				rel = $(clk).parents().eq(1).attr('rel');
				r = rel.split('-');
				$(clk).parents().eq(1).attr('rel',r[1]);
				
				p_id = r[1];
				cc_id = $(clk).parents().eq(1).attr('rel');
				for(i=0; i<tot; i++){
					c = $(clk).parents().eq(1).nextAll().eq(i).attr('cat');
					if(c=='c'){
						cc_id = $(clk).parents().eq(1).nextAll().eq(i).attr('rel');
						sp = cc_id.split('-');
						$(clk).parents().eq(1).nextAll().eq(i).attr('rel',p_id+'-'+undef(sp[1]));
					}else if(c=='p'){
						break;
					}
				}
			});
			$(this).toggleClass('fa-chevron-left fa-chevron-right');
		}
		$(this).parents().eq(1).attr('cat','p');
	});

	$("#user_form").bind('submit', function(e) {
		e.preventDefault();
		$('.empval').css('border','1px solid grey');
		pass = $('#pass').val();
		repass = $('#repass').val();
		if(EmptyCheckdyn('.empval')==1){
			$.notify('All fields are required!', 'danger');
			return false;
		}else if(pass!=repass){
			$.notify('Password not matched!', 'danger');
			return false;
		}else{
			ajaxsubmit($,'users.php',new FormData(this),'Saved');
		}
	});	
	
	//Read More button
	$('.e_content a').live('click', function(){
		tis = $(this);
		ids = $(tis).parents().eq(1).attr('rel');
		$.ajax({
			type: "post",
			url: 'rd-admin/call_ajax',
			data: 'getmore='+ids,
			success: function(data){
				$(tis).parents().eq(0).fadeOut(200,function(){
					$(tis).parents().eq(0).text(data);
					//ht = $(this).height() + 50;
					//$(this).animate({height:ht},1000);
					$(this).fadeIn();
				});	
			}
		});
	});
	
	//category slug
	$("#c_name, #c_slug").live('blur', function() {
		slug = $(this).val();
		slug_convert(slug,".c_slug");
	});
		
	$(".cinema-name, .flyer-city").live('blur', function() {
		slug = $(this).val();
		slugto = $(this).attr('rel');
		slug_convert(slug,slugto);
	});
	
	$('#ct_name').blur(function(a){
		slug = $(this).val();
		slug_convert(slug,".slug");
	});
	
	$('#gal_name, #gal_slug, #pg_slug').on('blur', function(){
		slug = $(this).val();
		slug_convert(slug,".ns_slug, .gal_slug, .pg_slug");
	});
			
	$('.epicdel').live('click', function (){
		pic = $(this).attr('rel'); // file name
		ids = $('#hidpic').val();
		r = confirm("Confirm to delete this Item!");
		if(ids!='' && r == true){
			$.ajax({
				type: "post",
				url: 'ad_ajax.php',
				data: 'pr_sldr_del='+ids+'&photos='+pic,
				success: function(data){
					if(data!=1){
						$.notify(data, 'danger');
					}else{
						$.notify('Successfully Deleted!.', 'success');
						ajax_reload('photo_edit');
					}
				}
			});
		}
	});	
	
	$("#catg_form").bind('submit', function(e) {
		e.preventDefault();
		$('.empval').css('border','1px solid grey');
		actbtn = $(this).find('input[type="submit"]').val();
		redrct = $(this).find('input[type="submit"]').attr('redirect');
		if(undef(redrct)==''){
			pagefile = document.location.pathname.match(/[^\/]+$/)[0];
		}else{
			pagefile = redrct;
		}
		if(EmptyCheckdyn('.empval')==1){
			$.notify({
				message: 'Focussed Fields are required!',
				status: 'danger',
				onClose: function(){}
			});
			return false;
		}else{
			$(this).find('input[type="submit"]').prop('disabled',true);
			blanket();
			for (instance in CKEDITOR.instances) {
				CKEDITOR.instances[instance].updateElement();
			}
			$.ajax({
				url: "call_ajax",
				type: "POST",
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData:false,
				success: function(data){
					msg = '';
					st = '';
					if(data!=1){
						msg = data;
						st = 'danger';
					}else{
						if(actbtn=='Update'){
							msg = 'Successfully Updated!';
							st = 'success';							
						}else{
							msg = 'Successfully Created!';
							st = 'success';
						}
					}
					$.notify({
						message: msg,
						status: st,
						onClose: function(){
							//window.location.href=pagefile;
						}
					});
				}
			});
		}
	});
		
	$('.sidebar-toggle').on('click',function(){
		rel = $(this).attr('rel');
		if(rel==1){
			$(this).attr('rel',0);
		}else{
			$(this).attr('rel',1);
		}
		$.post( ad_base+"ad_ajax.php", {sidebartogl:rel}, function( data ) {
			
		});
	});
		
	function closepop(){
		$('.timesave').hide();
	}
	
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
	
	function blanket(){
		$('#blanket').empty();
		$('#blanket').css('display','none');
		$('#blanket').css({
			'height':'100%',
			'width':'100%'
		});
		$('#blanket').prepend('<img id="theImg" src="../img/loader.gif" />');
		$('#blanket').css('display','block');
		$("#theImg").css({
			left: (($(window).width() - $('#theImg').width()) / 2),
			top: ($(window).width() - $('#theImg').width()) / 7,
			position:'absolute'
		});
	}
	
});

function notify(msg,st,rd=''){
	$.notify({
		message: msg,
		status: st,
		onClose: function(){
			if(rd==''){
				window.location.href=window.location.href;
			}else{
				window.location.href=rd;
			}
		}
	});
}

function slug_convert(slug,target){
	trimd = slug.trim();
	st1	= trimd.replace(/\W/g , " ");
	st2	= st1.replace(/\s+/g , "-").toLowerCase();
	$(target).val(st2);
}

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

function ajaxsubmit($,locatn,datam,msg,pos='',time='3000'){
	blanket();
	$.ajax({
		url: "ad_ajax.php",
		type: "POST",
		data: datam,
		//cache: false,
		processData:false,
		contentType: false,
		success: function(data){
			if(data==0){
				$.notify(data, 'danger');
			}else if(data==1){
				if(msg!=''){
					$.notify({message: 'Successfully '+msg+'!.', status: "success", timeout: time});
				}				
			}else if(data==2){
				$('form .errlog').remove();
				$('#email').css('border','1px solid #ccc');
				$('form').prepend('<span class="errlog col-md-12">EmailId already exist!</span>');
				$('#email').css('border','1px solid red');
				return false;
			}else if(data==3){
				$('form .errlog').remove();
				$('#mobile').css('border','1px solid #ccc');
				$('form').prepend('<span class="errlog col-md-12">Mobile no already exist!</span>');
				$('#mobile').css('border','1px solid red');
				return false;
			}
			$('form .errlog').remove();
			setTimeout(function(){
				//window.location.href=locatn;
			},time);
		}
	});
}

function blanket(){
	$('#blanket').empty();
	$('#blanket').css('display','none');
	$('#blanket').css({
		'height':'100%',
		'width':'100%'
	});
	$('#blanket').prepend('<img id="theImg" src="../img/loader.gif" />');
	$('#blanket').css('display','block');
	$("#theImg").css({
		left: (($(window).width() - $('#theImg').width()) / 2),
		top: ($(window).width() - $('#theImg').width()) / 7,
		position:'absolute'
	});
}

function isValidEmail(emailText) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailText);
};

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
    var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOP1234567890";
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