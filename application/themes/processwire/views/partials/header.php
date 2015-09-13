<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" /> 
    <?php echo $this->template->metadata() ?>

    <!-- Core Stylesheets - Include with every page -->
    <link rel="stylesheet" type="text/css" href="<?php echo theme_url('assets/css/style.css'); ?>" />

    <!-- Controller Defined Stylesheets -->
    <?php echo $this->template->stylesheets(); ?>

    <script type="text/javascript">
        var ADMIN_PATH = '<?php echo ADMIN_PATH; ?>';
        var ADMIN_URL = '<?php echo site_url(ADMIN_PATH); ?>';
        var THEME_URL = '<?php echo theme_url(); ?>';
    </script>

    <!-- Core Scripts - Include with every page -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="<?php echo theme_url('assets/js/jasny-bootstrap/jasny-bootstrap.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo theme_url('assets/js/helpers.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo theme_url('assets/js/superfish.js'); ?>"></script>

    <!-- Controller Defined JS Files -->
    <?php echo $this->template->javascripts(); ?>

    <!-- Google Analytics -->
    <?php echo $this->template->analytics(); ?>
</head>
<body>
    <div id="container">

        <div id="wrapper">
            <?php if ($this->secure->is_auth()): ?>
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.html">CMS</a>
                </div>
                <!-- /.navbar-header -->

                <ul class="nav navbar-top-links navbar-left">
                    <li><a class="top" onClick="window.name = 'ee_admin'" target="ee_cms" href="<?php echo site_url(); ?>">Visit Site</a></li>
                </ul>
                <!-- /.navbar-top-links -->

                <ul class="nav navbar-top-links navbar-right">
                    <?php if ($this->secure->is_auth()): ?>
                    <!-- .dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            Howdy, <?php echo $this->secure->get_user_session()->first_name; ?> <i class="fa fa-user fa-fw"></i> 
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                            </li>
                            <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="<?php echo site_url('users/logout'); ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                    <?php endif; ?>
                </ul>
                <!-- /.navbar-top-links -->

            </nav>
            <!-- /.navbar-static-top -->
            <nav class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <?php echo theme_partial('sidebar'); ?>                
                </div>
                <!-- /.sidebar-collapse -->
            </nav>
            <!-- /.navbar-static-side -->
             <?php endif; ?>