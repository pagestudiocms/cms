<!DOCTYPE html>
<html lang="{{ lang }}">
<head>
    <meta charset="utf-8">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="asset-host" content="">
    <meta name="asset-provider" content="default">

    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    {{ template:head }}
    
    <!-- Stylesheet Includes -->
	<link href="{{ theme_url }}/assets/css/nivo-lightbox.css" rel="stylesheet" />
	<link href="{{ theme_url }}/assets/css/nivo-lightbox-theme/default/default.css" rel="stylesheet" type="text/css" />
    <link href="{{ theme_url }}/assets/css/style.css" rel="stylesheet">
    
    <!-- Fonts -->
    <link href="{{ theme_url }}/assets/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700,900' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Ek+Mukta:400,600,700' rel='stylesheet' type='text/css'>

</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-custom">
    
    {{ if hero_image }}
        <section class="hero" id="intro" style="background-image: url('{{ helper:image_thumb image=hero_image source="true" }}');">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-right navicon">
                        <a id="nav-toggle" class="nav_slide_button" href="#"><span></span></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 text-center inner">
                        <div class="animatedParent">
                            <h1 class="animated fadeInDown">{{ heading }}</h1>
                            <p class="animated fadeInUp">{{ sub_heading }}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 text-center">
                        <a href="#about" class="learn-more-btn btn-scroll">Learn more</a>
                    </div>
                </div>
            </div>
        </section>
    {{ endif }}
    
    <!-- Navigation -->
    <div id="navigation">
        <nav class="navbar navbar-custom" role="navigation">
            <div class="container">
                <div class="row">
                    <div class="col-md-2">
                        <div class="site-logo">
                            <a href="{{ site_url }}" class="brand">PS</a>
                        </div>
                    </div>

                    <div class="col-md-10">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">
                            <i class="fa fa-bars"></i>
                            </button>
                        </div>
                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="menu">
                            {{ navigations:nav nav_id="1" class="nav navbar-nav navbar-right" }}
                        </div>
                        <!-- /.Navbar-collapse -->
                    </div>
                </div>
            </div>
            <!-- /.container -->
        </nav>
    </div> 
    <!-- /Navigation -->  
