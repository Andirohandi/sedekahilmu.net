<?php 
	$meta_judul = isset($meta_judul) ? $meta_judul : 'Sedekah Ilmu | sedekahilmu.net';
	$meta_deskripsi = isset($meta_deskripsi) ? $meta_deskripsi : 'Dengan sedekah berarti melatih keihklasan kita | sedekahilmu.net';
	$meta_image = isset($meta_image) ? $meta_image : base_url('assets/img/sedekah2.png');
	$meta_url = isset($meta_url) ? $meta_url : base_url();
	
?>

<html lang="en">
<head>
	  <meta charset="utf-8">
	  <title><?php echo $title; ?></title>
	  <meta name="viewport" content="width=device-width">
		<meta name="description" content="<?php echo $meta_deskripsi; ?>"/>
		
		<meta property="og:title" content="<?php echo $meta_judul; ?>" />
		<meta property="og:description" content="<?php echo $meta_deskripsi; ?>" />
		<meta property="og:image" content="<?php echo $meta_image; ?>" />
		<meta property="og:url" content="<?php echo $meta_url; ?>" />
		<meta property="og:site_name" content="Sedekah Ilmu" />
		
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bundle.css')?>" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css')?>" type="text/css" />
    <link href='https://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
    <link  href="<?php echo base_url(); ?>assets/img/sedekah3.ico" rel="shortcut icon">
    <script type="text/javascript" src="<?php echo base_url('assets/js/bundle.js')?>"></script>
</head>
<body style="padding-top:70px;font-family: 'Ubuntu', sans-serif;">
	<nav class="navbar navbar-default navbar-fixed-top" >
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo base_url(); ?>" style="font-family: 'Lobster', cursive;font-size:20px" >SedekahIlmu</a>
        </div>
    
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li class="<?php echo $menu == 'home' ? 'active' : '' ?>"><a href="<?php echo site_url(''); ?>" >Home <span class="sr-only">(current)</span></a></li>
            <li class="<?php echo $menu == 'navsedekahilmu' ? 'active' : '' ?>"><a href="<?php echo site_url('sedekahilmu/all'); ?>">Sedekah Ilmu</a></li>
            <li class="<?php echo $menu == 'author' ? 'active' : '' ?>"><a href="<?php echo site_url('sedekahilmu/author'); ?>">Authors</a></li>
            <li class="hide <?php echo $menu == 'profile' ? 'active' : '' ?>"><a href="<?php echo site_url('profile'); ?>">Profile</a></li>
            <li class="<?php echo $menu == 'about' ? 'active' : '' ?>"><a href="<?php echo site_url('about'); ?>">About</a></li>
            <li class="hide <?php echo $menu == 'contact' ? 'active' : '' ?>"><a href="<?php echo site_url('contact'); ?>">Contact</a></li>
          </ul>
          <form class="navbar-form navbar-left" role="search">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Search" style="background-color:#AB141D;border:1px solid #AB141D;" id='search_'>
            </div>
          </form>
          <div class="navbar-form navbar-right" >
            <div class="form-group">
              <?php if(!$this->session->userdata('logginUser')){ ?>
                <a href="<?php echo site_url('users/signup'); ?>" class="btn <?php echo $menu == 'signup' ? 'btn-trans-active' : 'btn-trans' ?>">Sign Up</a>
                <a href="<?php echo site_url('users/signin'); ?>" class="btn <?php echo $menu == 'signin' ? 'btn-trans-active' : 'btn-trans' ?>">Sign In</a>
              <?php }else{ ?>
                
                <?php if($this->session->userdata('userstatus_id') == 1){ ?>
                <a href="<?php echo site_url('users'); ?>" class="btn btn-info">Dashboard</a>
                <?php } ?>
                
                <a href="<?php echo site_url('users/signoutUser'); ?>" class="btn btn-trans">Sign Out</a>
              <?php } ?>
            </div>
          </div>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
	<div class="container">
    	<div class="row" style='min-height:600px'>