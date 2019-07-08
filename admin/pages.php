<?php
if(!isset($_SESSION)){ session_start(); }

if(isset($_REQUEST['action'])){
	$smactive = $_REQUEST['action'];
}else{
	$smactive = 'all' ;
}
if(isset($_REQUEST['action']) && $_REQUEST['action']=='addcat'){
	$title = 'Category';
	$mactive = 'addcat';
}else{
	$mactive = 'pages';
	$title = 'Page';
}
$in = 'pg';
?>
<?php include('header.php'); ?>
<div id="page-wrapper">
	<div class="container-fluid">
		<!-- Page Heading -->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">
					<?php echo $title; ?> <small>Creation</small>&nbsp;
				</h1>
				<ol class="breadcrumb">
					<li class="active">
						<i class="fa fa-files-o"></i> Category
					</li>
				</ol>
			</div>
		</div>
		<!-- /.row -->		
		<?php if(isset($_REQUEST['action']) && ($_REQUEST['action']=='addnew' || $_REQUEST['action']=='edit')){ ?>
		<div class="row">
			<div class="col-md-8">
				<form role="form" id="page_form" method="post" enctype="multipart/form-data">
					<div class="panel panel-default">
						<div class="panel-heading col-md-12 out-head" style="margin-bottom: 10px;">
							<?php if($_REQUEST['action']=='addnew'){
								echo '<span class="col-md-10" style="margin-top: 5px;">Add New Page</span>';
								$btnvl = 'pagesubmit';
								$svup = 'Save';
								$nm=$slg=$catg=$cntnt='';
							}else {
								echo '<span class="col-md-10" style="margin-top: 5px;">Edit Page</span>';
								$btnvl = 'pageupdate';
								$svup = 'Update';
								$args = array('rd_pages','*',array('p_id'=>$_GET['page']));
								$All = $fn->SlctAll($args);
								if(count($All) > 0){
									foreach($All as $key=>$row){
										echo '<input type="hidden" name="pageid" value="'.$row['p_id'].'">';
										$nm = $row['name'];
										$slg = $row['slug'];
										$cntnt = $row['content'];
										$catg = $row['category'];
									}
								}									
							}?>
							
							<span class="col-md-2">
								<input class="form-control btn btn-primary" id="pagesubmit" type="submit" value="<?php echo $svup; ?>" name="<?php echo $btnvl; ?>">
								<input type="hidden" name="<?php echo $btnvl; ?>">
							</span>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<input class="form-control empval" type="text" id="pg_slug" value="<?php echo $nm; ?>" placeholder="Page Name" name="pg_name" >
									</div>
									<div class="form-group">
										<input class="form-control empval pg_slug" type="text" value="<?php echo $slg; ?>" placeholder="Slug" name="pg_slug" >
									</div>
									<div class="form-group">
										<label>Select Category</label>
										<select class="form-control" name="catslug" id="">
											<option value="">Select</option>
											<?php 
												$args = array('rd_meta','*',array('meta_type'=>'category'));
												$All = $fn->SlctAll($args);
												if(count($All) > 0){
													foreach($All as $key=>$row){
														$selct = ($catg==$row['meta_slug']) ? 'selected' : '';
														echo '<option '.$selct.' value="'.$row['meta_slug'].'">'.$fn->Strlimit($row['meta_name'],35).'</option>';
													}
												}
											?>
										</select>
									</div>									
									<div class="form-group">
										<label>Featured Image</label>
										<input type="file" class="form-control" name="ftimage[]" >
									</div>									
									<div class="form-group"><?php  ?>
										<textarea style="display:none;" id="pg_content" name="pg_content"><?php 
										function replace_carriage_return($replace, $string)	{
											return str_replace(array("\n\r", "\n", "\r", "\r\n\r\n"), $replace, $string);
										}
										echo $cntnt; 
										//echo replace_carriage_return('xx', $cntnt);
										
										?></textarea>
										<?php //if($_REQUEST['action']=='edit'){ ?>
											<script type='text/javascript'>
												//CKEDITOR.replace('pg_content');
												CKEDITOR.replace('pg_content', {
													toolbar: [
														{
														  name: 'document',
														  items: ['Source']
														},
														{
														  name: 'clipboard',
														  items: ['Undo', 'Redo']
														},
														{
														  name: 'styles',
														  items: ['Format', 'Font', 'FontSize']
														},
														{
														  name: 'colors',
														  items: ['TextColor', 'BGColor']
														},
														{
														  name: 'align',
														  items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
														},
														'/',
														{
														  name: 'basicstyles',
														  items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'CopyFormatting']
														},
														{
														  name: 'links',
														  items: ['Link', 'Unlink']
														},
														{
														  name: 'paragraph',
														  items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']
														},
														{
														  name: 'insert',
														  items: ['Image', 'Table']
														},
														{
														  name: 'tools',
														  items: ['Maximize']
														},
														{
														  name: 'editing',
														  items: ['Scayt']
														}
													],

													extraAllowedContent: 'h3{clear};h2{line-height};h2 h3{margin-left,margin-top}',

													// Adding drag and drop image upload.
													extraPlugins: 'print,format,font,colorbutton,justify,uploadimage',
													uploadUrl: '../ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',

													// Configure your file manager integration. This example uses CKFinder 3 for PHP.
													filebrowserBrowseUrl: '../ckfinder/ckfinder.html',
													filebrowserImageBrowseUrl: '../ckfinder/ckfinder.html?type=Images',
													filebrowserUploadUrl: '../ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
													filebrowserImageUploadUrl: '../ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',

													height: 560,

													removeDialogTabs: 'image:advanced;link:advanced',
													fillEmptyBlocks: false
												});
												/*config.fillEmptyBlocks = false;
												if(window.CKEDITOR){
													CKEDITOR.on('instanceCreated', function (ev) {
														CKEDITOR.dtd.$removeEmpty['span'] = 0;
														CKEDITOR.dtd.$removeEmpty['TAG-NAME'] = 0;
													});
												}*/	
												//CKEDITOR.dtd.$removeEmpty.span = 0;
											</script>
										<?php //} ?>
									</div>
									<?php //include_once('extra_fields.php')
									
									?>
								</div>
							</div>						
						</div>
					</div>
				</form>
			</div>
		</div>
		<?php } else if(isset($_REQUEST['action']) && ($_REQUEST['action']=='addcat' || $_REQUEST['action']=='editcat')){ ?>
		<div class="col-lg-12">
			<div class="row col-md-4">
				<div class="col-md-12">
					<form role="form" id="catg_form" method="post" >
						<div class="panel panel-default">
							<div class="panel-heading col-md-12 out-head" style="margin-bottom: 10px; padding: 2px 15px;">
								<?php if($_REQUEST['action']=='addcat'){
									echo '<div class="col-md-8 pl-0 mt-2" style="margin-bottom: 10px; padding: 2px 15px;">Create Category</div>';
									$btnvl = 'catsubmit';
									$svup = 'Create';
									$nm = '';
									$slg = '';
								}else {
									echo '<div class="col-md-8 pl-0 mt-2" style="margin-bottom: 10px; padding: 2px 15px;">Update Category</div>';
									$btnvl = 'catupdate';
									$svup = 'Update';
									$args = array('rd_meta','*',array('m_id'=>$_GET['catg']));
									$All = $fn->SlctAll($args);
									if(count($All) > 0){
										foreach($All as $key=>$row){
											echo '<input type="hidden" name="m_id" value="'.$row['m_id'].'">';
											$nm = $row['meta_name'];
											$slg = $row['meta_slug'];
										}
									}
								}?>
								<div class="col-md-4 pr-0 text-right">
									<input class="btn btn-primary" id="catsubmit" type="submit" value="<?php echo $svup; ?>" name="catsubmit">
									<input type="hidden" name="catsubmit">
								</div>
							</div>
							<div class="panel-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="form-group">
											<input type="text" class="empval form-control" placeholder="Category Name" value="<?php echo $nm; ?>" id="c_name" name="c_name" >
										</div>
										<div class="form-group">
											<input type="text" class="empval form-control c_slug" placeholder="Slug" disabled id="c_slug" value="<?php echo $slg; ?>" >
											<input type="hidden" class="c_slug" value="<?php echo $slg; ?>" name="c_slug" >
											
										</div>			
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="row col-md-8" id="catg-list">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading out-head">Category List</div>
						<ul class="list-group" id="">
							<li class="list-group-item in-head">
								<div class="rd-left col-md-5">Name</div>
								<div class="col-md-3">Slug</div>
								<div class="col-md-2">Count</div>
								<div style="text-align: right;">Controls</div>
							</li>
							<?php
								$args = array('rd_meta','*',array('meta_type'=>'category'));
								$All = $fn->SlctAll($args);
								if(count($All) > 0){
									foreach($All as $key=>$row){
										echo '<li rel="'.$row['m_id'].'"  class="list-group-item ">
											<div class="rd-left col-md-5">'.$row['meta_name'].'</div>
											<div class="col-md-3">'.$row['meta_slug'].'</div>
											<div class="col-md-3">0</div>
											<div class="rd-">
												<a class="edits" title="Edit" rel="catg" href="javascript:void(0)"><span class="fa fa-edit"></span></a>
												<a class="deletes" alt="pages.php?action=addcat" title="Remove" rel="catg" href="javascript:void(0)"><span class="fa fa-remove"></span></a>
											</div>
										</li>';
									}
								}else{
									echo '<li style="text-align:center;" class="list-group-item">No records found!</li>';
								}
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		<?php if(!isset($_REQUEST['action'])){ ?>
		<div class="row">
			<div class="col-md-8">
				<div class="panel panel-default">
					<div class="panel-heading col-md-12 out-head" style="margin-bottom: 10px;">All Pages</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
								<ul class="list-group" id="page-load">
									<li class="list-group-item in-head">
										<div class="rd-left col-md-5">Name</div>
										<div class="col-md-4">Slug</div>
										<div class="col-md-1">Image</div>
										<div style="text-align: right;">Controls</div>
									</li>
									<?php
										$args = array('rd_pages','*');
										$All = $fn->SlctAll($args);
										if(count($All) > 0){
											foreach($All as $key=>$row){
												if($row['fileup']!=''){
													$img = '<img style="margin-top: -5px;" src="../uploads/pages/s_'.$row['fileup'].'" width="30" height=30>';
												}else{
													$img = '';
												}
												echo '<li rel="'.$row['p_id'].'" class="list-group-item">'.
														'<div title="'.$row['name'].'" class="rd-left col-md-5">'.$fn->Strlimit($fn->Getlang($row['name']),30).'</div>'.
														'<div class="col-md-4">'.$fn->Strlimit($row['slug'],25).'</div>'.
														'<div class="col-md-2">'.$img.'</div>'.
														'<div class="rd-">
														<a class="edits" title="Edit" rel="page" href="javascript:void(0)"><span class="fa fa-edit"></span></a>
														<a class="deletes" alt="pages.php" title="Remove" rel="page" href="javascript:void(0)"><span class="fa fa-remove"></span></a>
														</div>
													</li>';
											}
										}else{
											echo '<li style="text-align:center;" class="list-group-item">No records found!</li>';
										}
									?>
								</ul>
							</div>
						</div>						
					</div>
				</div>				
			</div>
		</div>
		<?php } ?>
	</div>
</div>
<?php include('footer.php'); ?>