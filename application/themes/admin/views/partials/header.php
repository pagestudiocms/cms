<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" /> 
    <?php echo $this->template->metadata() ?>

    <!-- CSS FILES -->
    <link rel="stylesheet" type="text/css" href="<?php echo theme_url('assets/css/style.css');  ?>" />

    <!-- Controller Defined Stylesheets -->
    <?php echo $this->template->stylesheets() ?>

    <script type="text/javascript">
        var ADMIN_PATH = '<?php echo ADMIN_PATH; ?>';
        var ADMIN_URL = '<?php echo site_url(ADMIN_PATH); ?>';
        var THEME_URL = '<?php echo theme_url(); ?>';
    </script>

    <!-- Controller Defined JS Files -->
    <?php echo $this->template->javascripts() ?>

    <script type="text/javascript" src="<?php echo theme_url('assets/js/tablesorter-pager.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo theme_url('assets/js/tablesorter.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo theme_url('assets/js/app.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo theme_url('assets/js/helpers.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo theme_url('assets/js/superfish.js'); ?>"></script>

    <!-- Google Analytics -->
    <?php /* echo $this->template->analytics(); */ ?>
</head>
<body <?php 
    if ($this->template->segment(3) === 'login') {
        echo 'class="login"';
    }
?>>

    <?php if ($this->secure->is_auth()): ?>
    <div id="header">
		<div id="top-menu">
			<a href="<?php echo site_url(ADMIN_PATH .'/settings/general-settings'); ?>" title="Settings">Settings</a> |
			<a href="mailto:support@cosmointeractive.co?subject=Support Request From <?php echo $this->settings->site_name ?>" title="Contact us">Support</a>
			
			<span>Logged in as <a href="<?php echo site_url(ADMIN_PATH . '/users/edit') .'/'. $this->secure->get_user_session()->id;?>" title="Logged in as admin"><?php echo $this->secure->get_user_session()->first_name . ' ' . $this->secure->get_user_session()->last_name ; ?></a></span>
			| <a href="<?php echo site_url('users/logout'); ?>" title="Logout">Logout</a>
		</div>
		<div id="sitename">
			<a href="<?php echo site_url('sitemin'); ?>" class="logo fleft" title="Admintasia">
                <span id="site_name"><?php echo $this->settings->site_name ?> <small>| ADMINISTRATION</small></span>
            </a>
			<div class="fright" style="margin-top: 5px;">
				<a class="btn blue small" onClick="window.name = 'ee_admin'" target="ee_cms" href="<?php echo site_url(); ?>">Visit Site</a>
			</div>
		</div>
        
        <?php echo theme_partial('main-navigation'); ?>
	</div>	
    <?php endif; ?>
    
    <div id="container">