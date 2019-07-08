<?php 
//include_once('beaver.php');

include_once('includes/ad-base.php');

include_once('includes/config.php');

include_once('pack.php');

if(basename($_SERVER['PHP_SELF'])=='index.php'){
	$menuslug = $name = 'index';
}

$m_t = '';
$m_k = '';
$m_d = '';
//echo $fn->Encr('test'); //$2y$10$yQDKkvLE/8ptFOhoLSIPbOzhSHpRnhlTTdc6KRRm1Cv4PLsTQdjOq
if($pg_slug!='index' && $pg_slug!='home'){
	/*$args = array('ns_posts','*',array('slug'=>$pg_slug));
	$All = $fn->slctAll($args);
	if(count($All) > 0){
		foreach($All as $key=>$m_row){
			if($m_row['m_title']!=''){
				$m_t = $m_row['m_title'];
			}
			if($m_row['m_key']!=''){
				$m_k = $m_row['m_key'];
			}
			if($m_row['m_desc']!=''){
				$m_d = $m_row['m_desc'];
			}
		}
	}
	if(!$ct_slug || ($ct_slug=='news' || $pg_slug=='gallery')){
		if($pg_slug=='gallery'){
			$ps = $ct_slug;
		}else{
			$ps = $pg_slug;
		}
		$args = array('ns_category','*',array('slug'=>$ps,'ct_type'=>'en'));
		$All = $fn->slctAll($args);
		if(count($All) > 0){
			foreach($All as $key=>$m_row){
				if($m_row['m_title']!=''){
					$m_t = $m_row['m_title'];
				}
				if($m_row['m_key']!=''){
					$m_k = $m_row['m_key'];
				}
				if($m_row['m_desc']!=''){
					$m_d = $m_row['m_desc'];
				}
			}
		}
	}*/
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<head>
	<!-- Favicon -->
	<link rel="shortcut icon" href="favicon.ico">
	<!-- Basic Page Needs
  ================================================== -->
	<meta charset="utf-8">
	<base href="<?php echo $base_url; ?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $m_t; ?></title>
	<meta name="description" content="<?php echo $m_d; ?>">
	<meta name="keywords" content="<?php echo $m_k;?>">
	<meta name="author" content="">
	<meta name="copyright" content=""/>
	<!-- Mobile Specific Metas
  ================================================== -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- CSS
  ================================================== -->
	<!-- Web Fonts -->
	<link rel='stylesheet' type='text/css' href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600&amp;subset=cyrillic,latin'>

	<!-- CSS Global Compulsory -->
	<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="css/styles.css">

	<!-- CSS Header and Footer -->
	<link rel="stylesheet" href="assets/css/headers/header-default.css">
	<link rel="stylesheet" href="assets/css/footers/footer-v1.css">

	<!-- CSS Implementing Plugins -->
	<link rel="stylesheet" href="assets/plugins/animate.css">
	<link rel="stylesheet" href="assets/plugins/line-icons/line-icons.css">
	<link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/plugins/parallax-slider/css/parallax-slider.css">
	<link rel="stylesheet" href="assets/plugins/owl-carousel/owl-carousel/owl.carousel.css">

	<link rel="stylesheet" href="assets/plugins/sky-forms-pro/skyforms/css/sky-forms.css">
	<link rel="stylesheet" href="assets/plugins/sky-forms-pro/skyforms/custom/custom-sky-forms.css">
	<!--[if lt IE 9]><link rel="stylesheet" href="assets/plugins/sky-forms-pro/skyforms/css/sky-forms-ie8.css"><![endif]-->
	<!-- CSS Theme -->
	<link rel="stylesheet" href="assets/css/theme-colors/default.css" id="style_color">
	<link rel="stylesheet" href="assets/css/theme-skins/dark.css">

	<!-- CSS Customization -->
	<link rel="stylesheet" href="assets/css/custom.css">
	<!--<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>-->
	<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css'>
	<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet">
    
	<!-- JS Global Compulsory -->
	<script type="text/javascript" src="assets/plugins/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="assets/plugins/jquery/jquery-migrate.min.js"></script>
	<script type="text/javascript" src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
	$(document).ready(function(){
		$('#search').on('click',function(){
			if($('#searchform').find('input').val()!=''){
				$('#searchform').submit();
			}else{
				alert('Please Type something to search!');
			}
		});
	})
</script>
</head>
<body class="" >
	<div class="container">
		<!--=== Header ===-->
		<div class="row">			
			<div class="container">
				<div class="col-md-3 pl-0 pr-0">
					<a class="logo" href="index.html">
						<img src="assets/img/new/logo.png" alt="Logo">
					</a>
					<button type="button" class="navbar-toggle" data-toggle="collapse"
						data-target=".navbar-responsive-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="fa fa-bars"></span>
					</button>
				</div>
				<div class="col-md-9 pt-4 pb-4 pr-0">
					<div class="col-md-4 pt-2 pt-md-4">
						<a class="float-md-right" href="tel:+919626262945"><i class="fas fa-mobile-alt"></i> +91 96262 62945</a>
					</div>
					<div class="col-md-4 pt-2 pt-md-4">
						<a class="float-md-right" href="https://api.whatsapp.com/send?phone=919626262952&text=Hi"><i class="fab fa-whatsapp"></i> +91 96262 62952</a>
					</div>
					<div class="col-md-4 pt-2 pt-md-4">
						<a class="float-md-right" href="mailto:knee.news@gmail.com"><i class="far fa-envelope"></i> knee.news@gmail.com</a>
					</div>
				</div>
			</div>
			<!--/end container-->
			<div class="container header">
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse mega-menu navbar-responsive-collapse">					
					<ul class="nav navbar-nav">
						<li class="<?php if($pg_slug == 'home'|| $pg_slug=='index' || $pg_slug=='/'){echo 'active';} ?>">
						<a href="<?php echo $base_url;?>">Home</a></li>
						<li class="<?php if($pg_slug == 'our-clinic' ||
											$pg_slug == 'dr-raj-kanna'){echo 'active';} ?> dropdown">
							<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
								About Us
							</a>
							<ul class="dropdown-menu">
								<li>
									<a href="dr-raj-kanna">Dr. Raj Kanna - Best Knee Surgeon India</a>
									<a href="our-clinic">Our Clinic</a>
								</li>										
							</ul>
						</li>
						<li class="<?php if($pg_slug == 'knee-arthritis' ||
											$pg_slug == 'anterior-cruciate-ligament-tear' ||
											$pg_slug == 'meniscal-tears' ||
											$pg_slug == 'patella-knee-cap-instability' ||
											$pg_slug == 'dislocation-of-the-knee' ||
											$pg_slug == 'posterior-cruciate-ligament-tear' ||
											$pg_slug == 'medial-collateral-ligament-tear' ||
											$pg_slug == 'lateral-collateral-ligament-tear' ||
											$pg_slug == 'failed-knee-surgeries') 
											{echo 'active';} ?> dropdown">
							<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
								Conditions Treated
							</a>
							<ul class="dropdown-menu">
								<li>
									<a href="knee-arthritis">Knee Arthritis</a>
									<a href="anterior-cruciate-ligament-tear">Anterior Cruciate Ligament Tear</a>
									<a href="meniscal-tears">Meniscal Tears</a>
									<a href="patella-knee-cap-instability">Patella (Knee Cap) Instability</a>
									<a href="dislocation-of-the-knee">Dislocation of the knee</a>
									<a href="posterior-cruciate-ligament-tear">Posterior Cruciate Ligament Tear</a>
									<a href="medial-collateral-ligament-tear">Medial Collateral Ligament Tear</a>
									<a href="lateral-collateral-ligament-tear">Lateral Collateral Ligament Tear</a>
									<a href="failed-knee-surgeries">Failed Knee Surgeries</a>
								</li>										
							</ul>
						</li>
						<li class="<?php if($pg_slug == 'our-mission-and-vision' ||
											$pg_slug == 'what-makes-us-unique'){echo 'active';} ?> dropdown">
							<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
								Why Us?
							</a>
							<ul class="dropdown-menu">
								<li>
									<a href="our-mission-and-vision">Our Mission and Vision</a>
									<a href="what-makes-us-unique">What Makes us Unique?</a>
								</li>										
							</ul>
						</li>
						<li class="<?php if($pg_slug == 'computer-assisted-knee-replacement' ||
											$pg_slug == 'arthroscopic-anatomical-acl-reconstruction' ||
											$pg_slug == 'key-hole-surgery-of-the-knee' ||
											$pg_slug == 'partial-knee-replacement' ||
											$pg_slug == 'revision-knee-replacement' ||
											$pg_slug == 'treatment-of-pcl-injury' ||
											$pg_slug == 'medial-patello-femoral-ligament-mpfl-construction' ||
											$pg_slug == 'stem-cell-therapy' ||
											$pg_slug == 'platelet-rich-plasma') 
											{echo 'active';} ?> dropdown">
							<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
								Services
							</a>
							<ul class="dropdown-menu">
								<li>
									<a href="computer-assisted-knee-replacement">Computer Assisted Knee Replacement</a>
									<a href="arthroscopic-anatomical-acl-reconstruction">Arthroscopic Anatomical ACL Reconstruction</a>
									<a href="key-hole-surgery-of-the-knee">Key-Hole Surgery of the Knee</a>
									<a href="partial-knee-replacement">Partial Knee Replacement</a>
									<a href="revision-knee-replacement">Revision Knee Replacement</a>
									<a href="treatment-of-pcl-injury">Treatment of PCL Injury</a>
									<a href="medial-patello-femoral-ligament-mpfl-construction">Medial Patello-Femoral Ligament (MPFL) Reconstruction</a>
									<a href="stem-cell-therapy">Stem Cell Therapy</a>
									<a href="platelet-rich-plasma">Platelet Rich Plasma</a>
								</li>										
							</ul>
						</li>
						<li class="<?php if($pg_slug == 'patient-guide'){echo 'active';} ?>">
							<a href="patient-guide">Patient guide</a>
						</li>
						<li class="<?php if($pg_slug == 'blogs'){echo 'active';} ?>">
							<a href="blogs">Blogs</a>
						</li>
						<li class="<?php if($pg_slug == 'written-testimonial' ||
											$pg_slug == 'knee-replacement-testimonials' ||
											$pg_slug == 'key-hole-surgery-testimonials')
											{echo 'active';} ?> dropdown">
							<a href="javascript:void(0);">Testimonial</a>
							<ul class="dropdown-menu">
								<li><a href="written-testimonial">written Testimonial</a></li>
								<li class="dropdown-submenu">
									<a href="javascript:void(0);">Video Testimonial</a>
									<ul class="dropdown-menu">
										<li>
											<a href="knee-replacement-testimonials">Knee Replacement Testimonials</a>
											<a href="key-hole-surgery-testimonials">Key Hole Surgery Testimonials</a>
										</li>												
									</ul>
								</li>										
							</ul>
						</li>
						<li class="<?php if($pg_slug == 'international-patients'){echo 'active';} ?>">
							<a href="international-patients">International Patients</a>
						</li>
						<li class="<?php if($pg_slug == 'news'){echo 'active';} ?>">
							<a href="news">News</a>
						</li>
						<li class="<?php if($pg_slug == 'knee-replacement-in-chennai'){echo 'active';} ?>">
							<a href="knee-replacement-in-chennai">Gallery</a>
						</li>
						<li class="<?php if($pg_slug == 'contact-us'){echo 'active';} ?>">
							<a href="contact-us">Contact Us</a>
						</li>						
						<!-- Search Block 
						<li>
							<i class="search fa fa-search search-btn"></i>
							<div class="search-open">
								<div class="input-group animated fadeInDown">
									<input type="text" class="form-control" placeholder="Search">
									<span class="input-group-btn">
										<button class="btn-u" type="button">Go</button>
									</span>
								</div>
							</div>
						</li>-->
						<!-- End Search Block -->
					</ul>
					<!--/end container-->
				</div>
				<!--/navbar-collapse-->
			</div>
		</div>
		<!--=== End Header ===-->
	</div>