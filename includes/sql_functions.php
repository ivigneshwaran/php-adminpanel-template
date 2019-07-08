<?php
class Funks{
	
	public $conn, $base_url;
		
	public function __construct() {
		$this->init();
	}
	
	public function init() {
		global $conn, $base_url;
		
		if(!isset($_SESSION)){ session_start(); }
		$this->conn = $conn;
		$this->base_url = $base_url;
	}
	
	public function r_e_s($input){ //Real Escape String
		if($input!=''){
			//return mysqli_real_escape_string($this->conn, trim($input));
			return $input;
		}
	}
	
	public function Encr($string){		
		$hash = password_hash($string, PASSWORD_DEFAULT);
		return $hash;
	}

	public function Decr($input,$hash){		
		if (password_verify($input, $hash)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function login(){
		if(isset($_SESSION['loguser'])){
			return true;
		}else{
			return false;
		}
	}
	
	public function dblogin($un,$ps){
		if($un!='' && $ps!=''){
			$args = array(
				'rd_users',
				'*',
				array('ad_username'=>$un,'ST'=>1)
			);
			$All = $this->SlctAll($args);			
			if(count($All) > 0) {
				foreach($All as $key=>$row){
					$pass = $row['ad_pwd'];
					if($this->Decr($ps,$pass)==true){
						$_SESSION['loguser'] = $row['ad_username'];
						$_SESSION['loguserid'] = $row['Uid'];
						return true;
					}
				}
			}
		}else{
			return false;
		}
	}	
		
	public function logout(){
		session_destroy();
		return true;
	}
	
	public function user(){
		echo $this->SlctOne(array('rd_users','ad_username',array('ad_username'=>$_SESSION['loguser'],'ST'=>1)));
	}	
	
	public function sanitize($in,$sep='and'){
		$arg = '';		
		if(!is_array($in)){		 // Select and Insert Query Format ========= id,username
			return rtrim($in,' ,');
		}else if(isset($in[0])){ // Select and Insert Query Format ========= (array('id','st'))
			foreach($in as $k=>$v){
				$arg .= $this->r_e_s($v).',';
			}			
			return rtrim($arg,' ,');
		}else if(isset($in)){	 // Insert and Update and Where Query Format ========= (array('id'=>3,'st'=>1)) associative array
			foreach($in as $k=>$v){
				$arg .= " ".$k."!\/!'".$this->r_e_s($v)."' ".$sep." ";
			}
			return rtrim($arg,' '.$sep);
		}
	}
	
	public function trm($in,$rep,$dir=''){
		if($in!='' && $rep!=''){
			if($dir=='r'){
				return rtrim($in,' '.$rep);
			}else if($dir=='l'){
				return ltrim($in,' '.$rep);
			}else if($dir==''){
				return trim($in,' '.$rep);
			}
		}
	}
	
	public function Whr($input,$sep='and'){
		if(isset($input) && is_array($input)){
			$p1 = $p2 = '';
			$p3 = array();
			foreach($input as $k=>$v){
				if(\strpos(strtolower($this->r_e_s($k)), ' like') !== false) {
					$p1 .= $this->r_e_s($k).' ? '.$sep.' ';
					$p2 .= 's';
					$p3[] = $v;
				}else if(\strpos(strtolower($this->r_e_s($k)), ' in') !== false) {
					$vcnt = explode(',',$v);
					$clause = implode(',', array_fill(0, count($vcnt), '?'));					
					$p1 .= $this->r_e_s($k).' ('.$clause.') '.$sep.' ';
					$p2 .= str_repeat('i', count($vcnt));
					foreach($vcnt as $ky=>$vl){
						$p3[] = $vl;
					}
				}else{
					$p1 .= $this->r_e_s($k).'= ? '.$sep.' ';
					$p2 .= 's';
					$p3[] = $this->r_e_s($v);
				}			
			}
			return array($this->trm($p1,$sep,'r'),$p2,$p3);
		}
	}
	
	public function Whr2($input){
		if(isset($input) && $input!=''){ // Where Conditions
			return $input;
		}
	}
	
	public function SlctOne($args,$ord='',$check=''){
		$All = $this->SlctAll($args,$ord,$check);
		if(count($All)>0){
			foreach($All as $key=>$val){
				if(isset($args[1]) && $args[1]==$key){
					return $val[$args[1]];
				}			
			}
		}
	}
	
	public function SlctAll($args,$ord='',$check=''){
		if(!empty($args)){
			$qry = $whrs = $qsns = $spl = $w = ''; $vals = array();
			
			if(isset($args[1])){ 	// Column names
				$qry .= ' '. $this->sanitize($args[1]) .' ';
			}
			
			if(isset($args[0])){ 	// Table Name
				$qry .= ' from '.$args[0];  
			}
			
			if(isset($args[2])){	// Where Conditions with LIKE, IN, NOT IN
				$prts = $this->Whr($args[2]);
				if(is_array($prts)){
					$whrs = $prts[0];
					$qsns = $prts[1];
					$vals = $prts[2]; 
				}
			}
			
			if(isset($args[3])){	// Where Conditions for like, In, Not in ....
				//$spl = $this->trm($this->Whr2($args[3]),' and','l'); 
				$spl = $this->Whr2($args[3]);
				if($whrs!=''){
					$spl = 'and '.$spl;
				}
			}			
			if($whrs!='' || $spl!=''){
				$w = 'where';
			}
			$sql = 'Select '.$qry.' '.$w.' '.$whrs.' '.$spl.' '.$ord;
			$this->check($sql,$check);
			return $this->exe_query(array($sql,$qsns,$vals));					
		}
	}
	
	public function InsertN($args,$check=''){
		//mysqli_set_charset($this->conn,"utf8");
		if(!empty($args)){
			$col = $tbl = $qsns = ''; $vals = array();
			
			if(isset($args[0])){ 	// Table Name
				$tbl = $args[0];  
			}
			
			if(isset($args[1])){ 	// Values for Columns
				$vals = explode('|\/|',$this->sanitize($args[1],'|\/|'));
				foreach($vals as $k=>$v){
					$c_v = explode('!\/!',$v);
					if(isset($c_v[0]) && isset($c_v[1])){
						$col .= $c_v[0].',';
					}
				}
			}
			
			$prts = $this->Whr($args[1]);
			if(is_array($prts)){
				$qsns = $prts[1];
				$vals = $prts[2]; 
			}
			
			if($tbl!='' && $col!=''){
				$qsnmarks = str_repeat('?,', count($vals));
				$sql = "INSERT INTO ".$tbl." (".rtrim($col,' ,').") VALUES (".rtrim($qsnmarks,' ,').")";
				$this->check($sql,$check);
				return $this->exe_query(array($sql,$qsns,$vals),2);				
			}
		}
	}
	
	public function UpdateN($args,$check=''){
		//$this->init();
		//mysqli_set_charset($this->conn,"utf8");
		if(!empty($args)){
			$tbl = $val = $spl = $whrs = $qsns = ''; $vals = array();
			
			if(isset($args[0])){ 	// Table Name
				$tbl = $args[0];  
			}
			
			$sets = $this->Whr($args[1],',');
			if(is_array($sets)){
				$val = $sets[0];
				$qsns = $sets[1];
				$vals = $sets[2];
			}
			$prts = $this->Whr($args[2]);
			if(is_array($prts)){
				$whrs = $prts[0];
				$qsns .= $prts[1];
				$vals = array_merge($vals,$prts[2]); 
			}
						
			if(isset($args[3])){	// Where Conditions for like, In, Not in ....
				//$spl = $this->trm($this->Whr2($args[3]),' and','l'); 
				//$spl = 'and '.$spl;
				$spl = $this->Whr2($args[3]);
				if($whrs!=''){
					$spl = 'and '.$spl;
				}
			}
			
			if($tbl!='' && $val!=''){
				$sql = "UPDATE ".$tbl." SET ".$val." WHERE ".$whrs." ".$spl;
				$this->check($sql,$check);
				return $this->exe_query(array($sql,$qsns,$vals),3);
			}
		}
	}
	
	public function DeleteN($args,$check=''){
		if(!empty($args)){
			$tbl = $whrs = $qsns = ''; $vals = array();
			
			if(isset($args[0])){ 	// Table Name
				$tbl = $args[0];  
			}
			
			$prts = $this->Whr($args[1]);
			if(is_array($prts)){
				$whrs = $prts[0];
				$qsns = $prts[1];
				$vals = $prts[2];
			}
			
			$sql = "Delete from ".$tbl." WHERE ".$whrs;
			$this->check($sql,$check);
			return $this->exe_query(array($sql,$qsns,$vals),4);			
		}		
	}
	
	public function JoinN($args,$check=''){
		if(!empty($args)){
			$qry = $whrs = $qsns = $spl = $w = ''; $vals = array();
			
			if(isset($args[0])){
				$qry = $this->r_e_s($args[0]);  
			}
			
			$prts = $this->Whr($args[1]);
			if(is_array($prts)){
				$whrs = $prts[0];
				$qsns = $prts[1];
				$vals = $prts[2];
			}
			
			if(isset($args[2])){	// Where Conditions for like, In, Not in ....
				$spl = $this->trm($this->Whr2($args[2]),' and','l'); 
				if($whrs!=''){
					$spl = 'and '.$spl;
				}
			}
			if($whrs!='' || $spl!=''){
				$w = 'where';
			}
			$sql = $qry." ".$w." ".$whrs." ".$spl;
			$this->check($sql,$check);
			return $this->exe_query(array($sql,$qsns,$vals),1);	
			
		}
	}
	
	public function check($sql,$check){
		if($check!=''){
			echo $sql; die;
		}
	}
	
	public function exe_query($sql,$sel=1){
		if(is_array($sql)){
			$qry = $sql[0]; $qsns = $sql[1]; $vals = $sql[2];
		}
		try{
			$stmt = $this->conn->prepare($qry);
			if($stmt === false){
				throw new Exception("Something Went Wrong!");
			}else{
				if($qsns!='' && is_array($vals)){
					$params= array_merge(array($qsns),$vals);
					$tmp = array();
					foreach($params as $key => $value){$tmp[$key] = &$params[$key];}
					call_user_func_array(array($stmt, 'bind_param'), $tmp);
				}
				$stmt->execute();
				if($sel==1){
					$result = $stmt->get_result();
					if($result->num_rows>0){
						$All = array();
						while($row = $result->fetch_assoc()) {
							 $All[] = $row;
						}
						return $All;
					}
				}else if($sel==2){
					return $this->conn->insert_id;
				}else if($sel==3){
					return $this->conn->affected_rows;
				}else if($sel==4){
					return 1;
				}
				$stmt->close();
			}
		}catch (Exception $e){
			echo 'Error: ' . $e->getMessage();
		}	
	}
	
	public function Original($content){
		$decode = htmlspecialchars_decode($content);
		$replce = preg_replace('~>\s*\n\s*<~', '><', $decode);
		//return htmlspecialchars_decode(trim(htmlentities($replce)));
		//return stripslashes(trim(htmlspecialchars_decode($replce)));
		return trim(htmlspecialchars_decode($replce));
	}
	
	public function NavMenu($actv,$li_cls='',$a_cls=''){
		$this->init();
		
		$ord = $this->SlctOne(array('rd_meta','meta_value',array('meta_name'=>'p_order')));
		if($ord!=''){
			$ordr = str_replace('.',',',$ord);
			$args = array(
				'rd_meta',
				'*',
				array('m_id in'=>$ordr)
			);
			$All = $this->SlctAll($args,'ORDER BY FIELD(m_id,'.$ordr.')');
			if(count($All) > 0){				
				foreach($All as $key=>$row){
					$last = '';
					if($key==0){
						$last = 'first-div';
					}
					if($actv==$row['meta_value']){
						echo '<div class="anibtn '.$last.'"><div class="button_base b04_3d_tick current_page_item '.$li_cls.'">
							<a class="'.$a_cls.'" href="'.$row['meta_value'].'">'.$this->Getlang($row['meta_name']).'</a>
							<a class="'.$a_cls.'" href="'.$row['meta_value'].'">'.$this->Getlang($row['meta_name']).'</a>
							'.$this->Submenu($row['m_id'],$actv).'</div></div>';
					}else{
						echo '<div class="anibtn '.$last.'"><div class="button_base b04_3d_tick '.$li_cls.'">
						<a class="'.$a_cls.'" href="'.$row['meta_value'].'">'.$this->Getlang($row['meta_name']).'</a>
						<a class="'.$a_cls.'" href="'.$row['meta_value'].'">'.$this->Getlang($row['meta_name']).'</a>
						'.$this->Submenu($row['m_id'],$actv).'</div></div>';
					}
				}
			}
		}
	}
	
	public function Submenu($ckval,$actv){
		$chld = $this->SlctOne(array('rd_meta','meta_value',array('meta_name'=>'c_order')));
		$flg=0;
		if($chld!=''){
			$in_ch = explode('.',$chld);
			foreach($in_ch as $key=>$val){
				$ch = explode('-',$in_ch[$key]);
				if($ch[0]==$ckval){
					$flg=1;
				}
			}
			if($flg==1){
				$tg = '<ul class="sub-menu">';
				foreach($in_ch as $key=>$val){
					$ch = explode('-',$in_ch[$key]);
					if($ch[0]==$ckval){
						$args = array(
							'rd_meta',
							'*',
							array('m_id'=>$ch[1])
						);
						$All = $this->SlctAll($args);
						if(count($All) > 0){
							foreach($All as $key=>$row){
								if($actv==$row['meta_value']){
									$tg .= '<li class="current_page_item"><a class="" href="'.$row['meta_value'].'">'.$this->Getlang($row['meta_name']).'</a></li>';
								}else{
									$tg .= '<li class=""><a class="" href="'.$row['meta_value'].'">'.$this->Getlang($row['meta_name']).'</a></li>';
								}
							}
						}
					}
				}
				$tg .= '</ul>';
				return $tg;
			}
		}
	}
	
	//=================== Responsive Menu=================
	public function NavMenuRes($actv,$li_cls='',$a_cls=''){
		$this->init();
		
		$ord = $this->SlctOne(array('rd_meta','meta_value',array('meta_name'=>'p_order')));
		if($ord!=''){
			$ordr = str_replace('.',',',$ord);
			$args = array(
				'rd_meta',
				'*',
				array('m_id in'=>$ordr)
			);
			$All = $this->SlctAll($args,'ORDER BY FIELD(m_id,'.$ordr.')');
			if(count($All) > 0){
				foreach($All as $key=>$row){
					if($actv==$row['meta_value']){
						echo '<li class="current_page_item '.$li_cls.'"><span><a class="'.$a_cls.'" href="'.$row['meta_value'].'">'.$this->Getlang($row['meta_name']).'</a></span>'.$this->SubmenuRes($row['m_id'],$actv).'</li>';
					}else{
						echo '<li class="'.$li_cls.'"><span><a class="'.$a_cls.'" href="'.$row['meta_value'].'">'.$this->Getlang($row['meta_name']).'</a></span>'.$this->SubmenuRes($row['m_id'],$actv).'</li>';
					}
				}
			}
		}
	}
	
	public function SubmenuRes($ckval,$actv){
		$chld = $this->SlctOne(array('rd_meta','meta_value',array('meta_name'=>'c_order')));
		$flg=0;
		if($chld!=''){
			$in_ch = explode('.',$chld);
			foreach($in_ch as $key=>$val){
				$ch = explode('-',$in_ch[$key]);
				if($ch[0]==$ckval){
					$flg=1;
				}
			}
			if($flg==1){
				$tg = '<ul class="sub-menu">';
				foreach($in_ch as $key=>$val){
					$ch = explode('-',$in_ch[$key]);
					if($ch[0]==$ckval){
						$args = array(
							'rd_meta',
							'*',
							array('m_id'=>$ch[1])
						);
						$All = $this->SlctAll($args);
						if(count($All) > 0){
							foreach($All as $key=>$row) {
								if($actv==$row['meta_value']){
									$tg .= '<li class="current_page_item"><a class="" href="'.$row['meta_value'].'">'.$this->Getlang($row['meta_name']).'</a></li>';
								}else{
									$tg .= '<li class=""><a class="" href="'.$row['meta_value'].'">'.$this->Getlang($row['meta_name']).'</a></li>';
								}
							}
						}
					}
				}
				$tg .= '</ul>';
				return $tg;
			}
		}
	}
	
	public function CallPlugin($plugin,$pg_slug){
		$this->pg_slug = $pg_slug;
		return include_once('plugins/'.$plugin.'/index.php');
	}
	
	public function Getlang($content){
		if(isset($_SESSION['current_lang']) && $_SESSION['current_lang']!=''){
			$crnt = $_SESSION['current_lang'];
		}else{
			$crnt = 'de';
		}		
		$lng = array('de','en','ta');
		if(in_array($crnt,$lng)){
			$f_mrk = '<!--:'.$crnt.'-->';
			$l_mrk = '<!--:-->';
			$fst = explode($f_mrk,$content);
			if(isset($fst[1]) && $fst[1]!=''){
				$main = explode($l_mrk,$fst[1]);
				if(isset($main[0])){
					return $main[0];
				}
				return '';
			}else{
				return $content;
			}
		}
	}
	
	function getdate($input){
		if($input=='0000-00-00' || $input==''){
			return '';
		}else{
			$timestamp = strtotime($input);
			return date('d-m-Y', $timestamp);
		}
	}
	
	//To make string limit
	public function Strlimit($text, $length =10){
		if(strlen($text)>$length){
			mb_internal_encoding("UTF-8");
			if(mb_substr($text,0,$length)==$text){
				return mb_substr(strip_tags($text),0,$length);
			}else{
				return mb_substr(strip_tags($text),0,$length).' ...';
			}
		}
		else{
			return strip_tags($text);
		}
	}
	
	function setdate($input){
		if($input=='0000-00-00' || $input==''){
			return '';
		}else{
			$timestamp = strtotime($input);
			return date('Y-m-d', $timestamp);
		}
	}
	
	function c_t($k1='',$k2=''){
		$ct = array(
				'c1'=>array('t1'=>'KinoABC'),
				'c2'=>array('t1'=>'KinoABC'),
				'c3'=>array('t1'=>'KinoABC'),
				'c4'=>array('t1'=>'KinoABC'),
				'c5'=>array('t1'=>'KinoABC'),
			);
		if($k1!='' && $k2!=''){
			return $ct[$k1][$k2];
		}else{
			return $ct;
		}
	}	
		
	//File upload function 
	public function FileUpload($vars,$ar,$newname,$fldr,$copy=1,$location='../'){
		$target_dir = $location."uploads/".$fldr;
		$target_file = $target_dir . basename($vars["name"][$ar]);
		$newname = $target_dir . $newname;
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		// Check if file already exists
		if (file_exists($newname)) {
			return "Sorry, file already exists.";
			$uploadOk = 0;
		}		
		// Allow certain file formats
		$inarray = array('jpg','jpeg','jpe','png','gif');
		if(!in_array($imageFileType,$inarray)){
			return "Sorry, only JPG, JPEG, PNG & GIF files are only allowed.";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			return "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
			$comprsd = $this->compress_image($vars["tmp_name"][$ar], $vars["tmp_name"][$ar], 50);
			//if (move_uploaded_file($vars["tmp_name"][$ar], $newname)) {
			if($copy>1){
				//if (move_uploaded_file($vars["tmp_name"][$ar], $newname)) {
					if($this->imgresize($vars["name"][$ar], $comprsd, $newname, $target_dir) == 1){
						if (move_uploaded_file($comprsd, $newname)) {
							return 1;
						}
					} else {
						return "Sorry, there was an error uploading your file.";
					}
				//}
			}else{
				if (move_uploaded_file($comprsd, $newname)) {
					return 1;
				} else {
					return "Sorry, there was an error uploading your file.";
				}
			}
		}
	}

	public function compress_image($source_url, $destination_url, $quality) {

		$info = getimagesize($source_url);

		if($info['mime'] == 'image/jpeg'){
			$image = imagecreatefromjpeg($source_url);
			imagejpeg($image, $destination_url, $quality);
		}elseif($info['mime'] == 'image/gif'){
			$image = imagecreatefromgif($source_url);
			imagegif($image, $destination_url, $quality);
		}elseif($info['mime'] == 'image/png'){			
			$image = imagecreatefrompng($source_url);
			list($width,$height) = getimagesize($source_url);
			$newWidth = intval($width);
			$newHeight = intval($height);
			$newImage = imagecreatetruecolor($newWidth, $newHeight);
			imagealphablending($newImage, false);
			imagesavealpha($newImage,true);
			$transparency = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
			imagefilledrectangle($newImage, 0, 0, $newHeight, $newHeight, $transparency);
			imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
			imagepng($newImage, $destination_url,5);
		}		
		return $destination_url;
	}
	
	public function imgresize($image, $uploadedfile, $newname, $paths){
		if ($image){			
			$filename = stripslashes($image);
			$extension = $this->getExtension($filename);
			$extension = strtolower($extension); 	// Lowercase =========================
			$in_jpg = array('jpg','jpeg','jpe');
			$in_png = array('png');
			$size= @filesize($uploadedfile);
			
			if(in_array($extension,$in_jpg)){ 		//jpg Family======
				$uploadedfile = $uploadedfile;
				$src = @imagecreatefromjpeg($uploadedfile);
			}
			else if(in_array($extension,$in_png)){	//png ============
				$uploadedfile = $uploadedfile;
				$src = @imagecreatefrompng($uploadedfile);
			}
			else{									//gif ============
				$src = @imagecreatefromgif($uploadedfile);
			}
						
			list($width,$height) = @getimagesize($uploadedfile);
			
			$arrs = array('l_'=>800,'m_'=>300,'s_'=>100);			// Multiple sizes
			$ii = 0;
			foreach($arrs as $k=>$val){
				${"newwidth".$ii} = $val;
				${"newheight".$ii} = ($height/$width) * ${"newwidth".$ii} ;
				${"tmp".$ii} = @imagecreatetruecolor( ${"newwidth".$ii} , ${"newheight".$ii} );	
				
				${"filename".$ii} = str_replace($paths,$paths.$k,$newname);
				
				if(in_array($extension,$in_jpg)){
					$white = @imagecolorallocate( ${"tmp".$ii} , 255, 255, 255);
					@imagefill( ${"tmp".$ii} , 0, 0, $white);
					@imagecopyresampled( ${"tmp".$ii} ,$src,0,0,0,0, ${"newwidth".$ii} , ${"newheight".$ii} ,$width,$height);
					
					imagejpeg( ${"tmp".$ii} , ${"filename".$ii} );
				}else if(in_array($extension,$in_png)){
					@imagealphablending( ${"tmp".$ii} , false);
					@imagesavealpha( ${"tmp".$ii} ,true);
					$transparency = @imagecolorallocatealpha( ${"tmp".$ii} , 255, 255, 255, 127);
					@imagefilledrectangle( ${"tmp".$ii} , 0, 0, ${"newheight".$ii} , ${"newheight".$ii} , $transparency);
					@imagecopyresampled( ${"tmp".$ii} , $src, 0, 0, 0, 0, ${"newwidth".$ii} , ${"newheight".$ii} , $width, $height);
					
					imagepng( ${"tmp".$ii} , ${"filename".$ii} );
				}else{
					$white = @imagecolorallocate( ${"tmp".$ii} , 255, 255, 255);
					@imagefill( ${"tmp".$ii} , 0, 0, $white);
					@imagecopyresampled( ${"tmp".$ii} ,$src,0,0,0,0, ${"newwidth".$ii} , ${"newheight".$ii} ,$width,$height);
					
					imagegif( ${"tmp".$ii} , ${"filename".$ii} );
				}
				imagedestroy( ${"tmp".$ii} );
				
				$ii++;
			}
			return 1;
		}
	}
	
	public function getExtension($str) {
		$i = strrpos($str,".");
		if (!$i) { return ""; }
		$l = strlen($str) - $i;
		$ext = substr($str,$i+1,$l);
		return $ext;
	}
	
	public function FileDel($path,$file){
		$arr = array('l_','m_','s_','');
		foreach($arr as $val){
			if($file!='' && file_exists($path.$val.$file)){
				unlink($path.$val.$file);
			}
		}
	}
	
	public function Clean($string) {
		$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
		return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}
	
	public function Countries($in=''){
		return $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba",
							"Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia",
							"Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi",
							"Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", 
							"Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire",
							"Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", 
							"El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", 
							"France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", 
							"Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", 
							"Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", 
							"Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", 
							"Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", 
							"Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", 
							"Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", 
							"Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", 
							"New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", 
							"Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", 
							"Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", 
							"Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", 
							"South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", 
							"Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", 
							"Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", 
							"Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", 
							"Yugoslavia", "Zambia", "Zimbabwe");

	}
}
$fn = new Funks();
?>