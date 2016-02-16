<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8" /> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <?php echo $this->template->metadata(); ?>
    
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <!-- CSS FILES -->
    <link rel="stylesheet" type="text/css" href="<?php echo theme_url('assets/css/style.css');  ?>" />

    <!-- Controller Defined Stylesheets -->
    <?php echo $this->template->stylesheets(); ?>

    <script type="text/javascript">
        var ADMIN_PATH = '<?php echo ADMIN_PATH; ?>';
        var ADMIN_URL = '<?php echo site_url(ADMIN_PATH); ?>';
        var THEME_URL = '<?php echo theme_url(); ?>';
    </script>
    
    <!-- Controller Defined JS Files -->
    <?php echo $this->template->javascripts(); ?>

    <script src="<?php echo theme_url('assets/js/jquery.menu-aim.js'); ?>"></script>
    <script src="<?php echo theme_url('assets/js/main.js'); ?>"></script>
    <script src="<?php echo theme_url('assets/js/modernizr.js'); ?>"></script> <!-- Modernizr -->
    
    <script type="text/javascript" src="<?php echo theme_url('assets/js/helpers.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo theme_url('assets/js/superfish.js'); ?>"></script>

    <!-- Google Analytics -->
    <?php /* echo $this->template->analytics(); */ ?>
</head>
<body <?php 
    if ($this->template->segment(3) === 'login' || $this->template->segment(3) === 'forgot-password') {
        echo 'class="login"';
    }
?>>
<?php if ($this->secure->is_auth()): ?>

	<header class="cd-main-header">
		<a href="#0" class="cd-logo"><img src="<?php echo theme_url('assets/img/cd-logo.svg'); ?>" alt="Logo"></a>
        
        <div class="breadcrumb">
            <ul><?php echo isset($breadcrumb) ? $breadcrumb : ''; ?></ul>
        </div>

		<a href="#0" class="cd-nav-trigger">Menu<span></span></a>

		<nav class="cd-nav">
			<ul class="cd-top-nav">
				<li><a class="btn blue small" onClick="window.name = 'ee_admin'" target="ee_cms" href="<?php echo site_url(); ?>">Visit Site</a></li>
				<li><a class="settings-icon" href="<?php echo site_url(ADMIN_PATH .'/settings/general-settings'); ?>" title="Settings"><i class="fa fa-cog">&nbsp;</i><span>Settings</span></a></li>
				<li class="has-children account">
					<a href="#0">
						<img src="<?php echo theme_url('assets/img/cd-avatar.png'); ?>" alt="Profile Avatar">
						<?php echo $this->secure->get_user_session()->first_name; ?>
					</a>

					<ul>
						<li><a href="<?php echo site_url(ADMIN_PATH . '/users/edit') .'/'. $this->secure->get_user_session()->id;?>">Edit Account</a></li>
						<li><a href="<?php echo site_url('users/logout'); ?>" title="Logout">Logout</a></li>
					</ul>
				</li>
			</ul>
		</nav>
	</header> <!-- .cd-main-header -->

	<main class="cd-main-content">
		<nav class="cd-side-nav">            
            <?php echo theme_partial('main-navigation'); ?>
		</nav>

		<div class="content-wrapper">    
            
            <div id="container">
<?php endif; ?>