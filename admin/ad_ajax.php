<?php 

include_once('../includes/config.php');

//User Create =================
if(isset($_POST['usersubmit'])){
	$uname = $_POST['uname'];
	$pass = $_POST['pass'];
	if($uname!='' && $pass!=''){
		$pass = $fn->Encr($pass);
		$args = array(
			'rd_users',
			array('ad_username'=>$uname,'ad_pwd'=>$pass),
		);
		if($fn->InsertN($args)>0){
			echo 1;
		}else{
			echo 0;
		}
	}else{
		echo 'Something went Wrong!';
	}
}

//User Update =================
if(isset($_POST['userupdate'])){
	$uid = $_POST['mt_id'];
	$uname = $_POST['uname'];
	$pass = $_POST['pass'];
	if($uname!='' && $pass!=''){
		$pass = $fn->Encr($pass);
		$args = array(
			'rd_users',
			array('ad_username'=>$uname,'ad_pwd'=>$pass),
			array('Uid'=>$uid)
		);
		if($fn->UpdateN($args)==1){
			echo 1;
		}else{
			echo 0;
		}
	}else{
		echo 'Something went Wrong!';
	}
}

//User Delete =================
if(isset($_POST['userdel'])){
	$args = array('rd_users',array('id'=>$_POST['userdel']));
	if($fn->DeleteN($args)){
		echo 1;
	}else{
		echo 0;
	}
}

//Logo Create =================
if(isset($_POST['logosubmit'])){
	$flname = $_FILES["logo"]["name"][0];
	$temp = explode(".",$flname);
	$newname = 'Logo-' . rand(1,99999) . '.' .end($temp);
	if($flname!=''){
		if($fn->FileUpload($_FILES['logo'],0,$newname,'logo/')!=1){
			echo 0;
		}else{
			$logo = $fn->SlctOne(array('rd_meta','meta_value',array('meta_name'=>'logo')));
			$args = array(
				'rd_meta',
				array('meta_name'=>'logo','meta_value'=>$newname),				
			);
			if($logo!=''){
				$fn->FileDel('../uploads/logo/',$logo);				
				array_push($args,array('meta_name'=>'logo'));
				if($fn->UpdateN($args)==1){
					echo 1;
				}else{
					echo 0;
				}
			}else{
				if($fn->InsertN($args)>0){
					echo 1;				
				}else{
					echo 0;
				}
			}
		}
	}
}

//Media Create =================
if(isset($_POST['mediasubmit'])){
	$caption = $_POST['caption'];
	$pageslug = $_POST['pageslug'];
	$mt_id = $_POST['mt_id'];
	for ($i = 0; $i < count($_FILES["media"]["name"]); $i++) {
		$flname = $_FILES["media"]["name"][$i];
		$temp = explode(".",$flname);
		$newname = 'Lib-' . rand(1,99999) . '.' .end($temp);
			if($flname!=''){
				if($fn->FileUpload($_FILES['media'],$i,$newname,'media/',2)!=1){ // if added "2" at the last parameter which means file resize
					$out = 0;
				}else{
					$args = array(
						'rd_meta',
						array('meta_type'=>'media','meta_name'=>$caption,'meta_slug'=>$pageslug,'meta_value'=>$newname),						
					);
					if($fn->InsertN($args)>0){
						$out = 1;
					}else{
						$out = 0;
					}			
				}
			}
	}
	echo $out;
}

//Media Create =================
if(isset($_POST['mediaupdate'])){
	$caption = $_POST['caption'];
	$pageslug = $_POST['pageslug'];
	$mt_id = $_POST['mt_id'];
	$out = 1;
	
	$flname = $_FILES["media"]["name"][0];
	$file = $fn->SlctOne(array('rd_meta','meta_value',array('m_id'=>$mt_id)));
	$newname = $file;
	if($flname!=''){
		$fn->FileDel('../uploads/media/',$file);
				
		$temp = explode(".",$flname);
		$newname = 'Lib-' . rand(1,99999) . '.' .end($temp);
		
		if($fn->FileUpload($_FILES['media'],0,$newname,'media/',2)!=1){ // if added "2" at the last parameter which means file resize
			$out = 0;
		}else{
			$out = 1;			
		}
	}
	$args = array(
		'rd_meta',
		array('meta_name'=>$caption,'meta_slug'=>$pageslug,'meta_value'=>$newname),
		array('m_id'=>$mt_id)
	);
	if($fn->UpdateN($args)==1 && $out==1){
		$out = 1;
	}else{
		$out = 0;
	}
	echo $out;
}

//Media Delete =================
if(isset($_POST['mediadel'])){
	$file = $fn->SlctOne(array('rd_meta','meta_value',array('m_id'=>$_POST['mediadel'])));
	$fn->FileDel('../uploads/media/',$file);
	
	$args = array('rd_meta',array('m_id'=>$_POST['mediadel']));
	if($fn->DeleteN($args)){
		echo 1;
	}else{
		echo 0;
	}
}

//Page Create =================
if(isset($_POST['pagesubmit']) || isset($_POST['pageupdate'])){
	
	$pg_name = $_POST['pg_name'];
	$pg_slug = $_POST['pg_slug'];
	$catg = $_POST['catslug'];
	//$pg_content = mysqli_real_escape_string($fn->conn, $_POST['pg_content']);
	$pg_content = $_POST['pg_content'];
	$newname = $file = '';
	if(isset($_POST['pageid'])){
		$pg_id = $_POST['pageid'];
		$file = $fn->SlctOne(array('rd_pages','fileup',array('p_id'=>$pg_id)));
		$newname = $file;
	}
	
	$flname = $_FILES["ftimage"]["name"][0];
	
	$fileup = 1;
	if($flname!=''){
		if($file!=''){
			$fn->FileDel('../uploads/pages/',$file);
		}
		$temp = explode(".",$flname);
		$newname = 'Page-' . date('dmYHis') . '.' .end($temp);
		if($fn->FileUpload($_FILES['ftimage'],0,$newname,'pages/',2)==1){
			$fileup = 1;
		}else{
			$fileup = 0;
		}
	}
	if($pg_name!='' && $pg_slug!='' && $fileup==1){
		$args = array(
			'rd_pages',
			array(
				'name'		=> $pg_name,
				'slug'		=> $pg_slug,
				'content'	=> $pg_content,
				'category'	=> $catg,
				'fileup'	=> $newname
			)
		);
		if(!isset($_POST['pageid'])){
			if($fn->InsertN($args)>0){
				echo 1;
			}
		}else{
			array_push($args,array('p_id'=>$pg_id));
			if($fn->UpdateN($args)>0){
				echo 1;
			}
		}		
	}
}

//Page Delete =================
if(isset($_POST['pagedel'])){
	$file = $fn->SlctOne(array('rd_pages','fileup',array('p_id'=>$_POST['pagedel'])));
	$fn->FileDel('../uploads/pages/',$file);
	
	$args = array('rd_pages',array('p_id'=>$_POST['pagedel']));
	if($fn->DeleteN($args)){
		//$fn->DeleteN(array('rd_pagemeta',array('page_id'=>$_POST['pagedel'])));
		echo 1;
	}else{
		echo 0;
	}
}

//Category Create and Update =================
if(isset($_POST['catsubmit'])){
	$c_name = $_POST['c_name'];
	$c_slug = $_POST['c_slug'];
	$m_id = '';
	if(isset($_POST['m_id'])){
		$m_id = $_POST['m_id'];
	}
	$args = array(
		'rd_meta',
		array(
			'meta_type'	=> 'category',
			'meta_name'	=> $c_name,
			'meta_slug'	=> $c_slug,
		)
	);
	if($c_name!='' && $c_slug!='' && $m_id==''){		
		if($fn->InsertN($args)>0){
			echo 1;
		}else{
			echo 0;
		}
	}else{
		array_push($args,array('m_id'=>$m_id));
		if($fn->UpdateN($args)==1){
			echo 1;
		}else{
			echo 0;
		}
	}
}

//Category Delete =================
if(isset($_POST['catdel'])){
	$args = array('rd_meta',array('m_id'=>$_POST['catdel']));
	if($fn->DeleteN($args)){
		echo 1;
	}else{
		echo 0;
	}
}

//Menu Create =================
if(isset($_POST['menusubmit'])){
	$m_name = $_POST['m_name'];
	$m_url = $_POST['m_url'];
	if($m_name!='' && $m_url!=''){
		$args = array(
			'rd_meta',
			array(
				'meta_type'	=> 'menu',
				'meta_name'	=> $m_name,
				'meta_value'=> $m_url,
			)
		);
		$lstid = $fn->InsertN($args);
		if($lstid>0){
			$p_in = $fn->SlctOne(array('rd_meta','meta_value',array('meta_name'=>'p_order')));
			$args = array(
				'rd_meta',
				array(					
					'meta_value' => $p_in.'.'.$lstid
				),
				array('meta_name'=> 'p_order')
			);
			if($fn->UpdateN($args)==1){
				echo 1;
			}else{
				echo 0;
			}			
		}else{
			echo 0;
		}
	}
}

//Menu Update =================
if(isset($_POST['menuupdate'])){
	$m_name = $_POST['m_name'];
	$m_url = $_POST['m_url'];
	$m_id = $_POST['m_id'];
	if($m_name!='' && $m_url!=''){
		$args = array(
			'rd_meta',
			array(
				'meta_type'	=> 'menu',
				'meta_name'	=> $m_name,
				'meta_value'=> $m_url
			),
			array('m_id'	=> $m_id)
		);
		if($fn->UpdateN($args)==1){
			echo 1;
		}else{
			echo 0;
		}
	}
}

//Menu Delete =================
if(isset($_POST['m_delete'])){
	$args = array('rd_meta',array('m_id'=>$_POST['m_delete']));
	if($fn->DeleteN($args)){
		echo 1;
	}else{
		echo 0;
	}
}

//Menu Order =================
if(isset($_POST['prnt'])){
	$prnt = rtrim($_POST['prnt'],' .');
	$chld = rtrim($_POST['chld'],' .');
	$p_in = $fn->SlctOne(array('rd_meta','meta_name',array('meta_name'=>'p_order')));
	
	$p_res=$c_res='';
	$args = array(
		'rd_meta',
		array(
			'meta_type'	=> 'm_order',
			'meta_name'	=> 'p_order',
			'meta_value'=> $prnt
		),		
	);
	if($p_in!=''){
		array_push($args,array('meta_name' => 'p_order'));
		if($fn->UpdateN($args)==1){
			$p_res  = 1;
		}else{
			$p_res  = 0;
		}
	}else{
		if($fn->InsertN($args)>0){
			$p_res  = 1;
		}else{
			$p_res  = 0;
		}
	}
	
	
	$c_in = $fn->SlctOne(array('rd_meta','meta_name',array('meta_name'=>'c_order')));
	$args1 = array(
		'rd_meta',
		array(
			'meta_type'	=> 'm_order',
			'meta_name'	=> 'c_order',
			'meta_value'=> $chld
		),		
	);	
	if($c_in!=''){
		array_push($args1,array('meta_name' => 'c_order'));
		if($fn->UpdateN($args1)==1){
			$c_res = 1;
		}else{
			$c_res = 0;
		}
	}else{
		if($fn->InsertN($args1)>0){
			$c_res = 1;
		}else{
			$c_res = 0;
		}
	}
	
	
	if($p_res!=''){
		echo $p_res;
	}else if($c_res!=''){
		echo $c_res;
	}
}

//Set language
if(isset($_POST['crnt_lang'])){
	$_SESSION['current_lang']=$_POST['crnt_lang'];
	echo 1;
}

// Get more
if(isset($_POST['getmore'])){
	echo $fn->SlctOne(array('rd_cinemas','e_content',array('e_id'=>$_POST['getmore'])));
}

//Set Session ================
if(isset($_POST['sesmvids'])){
	if(isset($_SESSION['sesthtr'])){
		unset($_SESSION['sesthtr']);
	}
	$_SESSION['setmv_ids'] = $_POST['sesmvids'];
	$_SESSION['setcitykey'] = $_POST['citycode'];
	echo "http://" . $_SERVER['SERVER_NAME'].'/booking';
}

//filterdt ===============
if(isset($_POST['filterdt'])){
	$originalDate = $_POST['filterdt'];
	$newDate = date("d-m-Y", strtotime($originalDate));
	$current = date("d-m-Y");
	$seldate=strtotime($newDate);
	$curdate=strtotime($current);
	$shows = $fn->SlctOne(array('rd_meta','meta_value',array('meta_type'=>'cityrel','meta_slug'=>$_POST['ct_id'])));
	$sh_tms = array();
	if($shows!=''){
		$step1 = explode('~',$shows);
		foreach($step1 as $k => $v){
			$step2 = explode('-',$v);
			if(trim($step2[0]) == trim($_POST['thtrshow'])){
				$sh_tms = explode(',',$step2[1]);
				break;
			}
		}
	}
	if($seldate == $curdate){
		$cr_tm = date('H:i');
		$timestamp = strtotime($cr_tm) + 60*60;
		$c_time = date('H:i', $timestamp);
		$t1 = strtotime($c_time);
		$nt = '';
		foreach($sh_tms as $v){echo $v;
			$t2 = strtotime($v);
			if($t1<$t2){
				echo '<option value="'.$v.'">'.$v.'</option>';
			}
		}
	}else if($_POST['filterdt']!=''){
		foreach($sh_tms as $v){
			echo '<option value="'.$v.'">'.$v.'</option>';
		}
	}
}

if(isset($_POST['checkdate'])){
	$today = date("Y-m-d");	
	if (dtformt($_POST['checkdate']) == $today) {
		$ts1 = strtotime($_POST['checktime']);
		$ts2 = strtotime('now');
		$diff = abs($ts1 - $ts2) / 3600;
		if($diff > 3){
			echo $diff;
		}
	}else{
		echo 1;
	}
}

function dtformt($in){
	$date = date_create($in);
	return date_format($date,"Y-m-d");
}

function selected($in,$comp){
	if($in==$comp){
		return 'selected';
	}
}


?>