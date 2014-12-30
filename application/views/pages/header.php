<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript" src="<?=base_url()?>js/jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="<?=base_url()?>js/bootstrap.min.js"></script>
    <link type="text/css" rel="stylesheet" href="<?=base_url()?>css/bootstrap.min.css" />
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
                <ul class="nav navbar-nav navbar-right">
					<?php 

					       echo    "<li><a href='". base_url(). "login'>Login</a></li>
					                <li><a href='". base_url(). "register'>Regist</a></li>";
					?>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</nav>