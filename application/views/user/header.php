<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript" src="<?=base_url()?>js/jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/jquery.jqplot.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/plugins/jqplot.pieRenderer.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/plugins/jqplot.donutRenderer.min.js"></script>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="<?=base_url()?>js/excanvas.min.js"></script>
    <![endif]-->
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>css/bootstrap.min.css" />
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>css/jquery.jqplot.min.css" />
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>css/pages.css" />
    <title>Semantic Classifier</title>
</head>
<body>
	<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?=base_url()?>">Sematic Classifier</a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li<?php echo ($page == 'index')? " class='active'": "";?>><a href="<?=base_url()?>">Project Index</a></li>
					<li<?php echo ($page == '#')? " class='active'": "";?>><a href="<?=base_url()?>contact">Contact</a></li>
				</ul>
				<form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
                <ul class="nav navbar-nav navbar-right">
					<li class='dropdown'>
	                   <a href='#' class='dropdown-toggle' data-toggle='dropdown'>
	                       <?=$userInfo['userName']?>
		                   <span class='caret'></span>
	                   </a>
	                   <ul class='dropdown-menu' role='menu'>
		                  <li class='dropdown-header'>controller</li>
		                  <li><a href='#'>My account</a></li>
  		                  <li><a href='#'>Security</a></li>
  		                  <li><a href='#'>My mark</a></li>
		                  <li class='divider'></li>
		                  <li><a href='<?=base_url()?>user/logout'>Exit</a></li>
	                   </ul>
                    </li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</nav>