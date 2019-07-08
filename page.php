<?php
$in_pages = array('disclaimer','advertisement','about-us','privacy');

if($pg_slug=='index' || $pg_slug=='home'){
	include_once('home.php');
}else if($pg_slug=='demo'){
	include_once('demo.php');
}else if($pg_slug=='search'){
	include_once('inner.php');
?>
<?php }elseif($pg_slug=='gallery' || (isset($ct_slug) && $pg_slug=='gallery')){ ?>
	<?php include_once('gallery.php'); ?>
<?php }elseif(isset($ct_slug) && $ct_slug=='search'){ ?>
	<?php include_once('search.php'); ?>
<?php }elseif($pg_slug=='contact-us' || $pg_slug=='contact'){ ?>
	<?php include_once('forms.php'); ?>
<?php }elseif($pg_slug=='book-appointment' || $pg_slug=='appointment'){ ?>
	<?php include_once('book-appointment.php'); ?>
<?php
}else{
	$pages = $fn->SlctOne(array('rd_pages','p_id',array('slug'=>$pg_slug,'st'=>'0')));
	if($pages!=''){
		include_once('inner.php');
	}else{
		//include_once('404.php');
	}
	
}
?>
<div class="clear"></div>