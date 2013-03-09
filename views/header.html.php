<!DOCTYPE html>

<html>
	<head>
		<title><?php echo $this->htmlEncode($this->app->getConfig('siteName')) . ' - ' . $this->get('pageTitle') ?></title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link href="<?php echo $this->app->getRootPath() ?>views/lib/bootstrap/css/readable.css" rel="stylesheet">
		<link href="<?php echo $this->app->getRootPath() ?>views/css/layout.css" rel="stylesheet">

		<script src="<?php echo $this->app->getRootPath() ?>views/lib/jquery-1.9.1.min.js"></script>
		<script src="<?php echo $this->app->getRootPath() ?>views/js/readable.js"></script>

		<script>
			readable.rootPath = '<?php echo $this->app->getRootPath() ?>';
		</script>
	</head>
	<body>
		<header class="navbar navbar-fixed-top ">
			<div class="navbar-inner">
				<div class="container">
					<a class="brand" href="<?php echo $this->app->getRootPath() ?>">Readable.cc</a>

					<ul class="nav">
						<li class="<?php echo $this->name == 'index' ? 'active' : '' ?>"><a href="<?php echo $this->app->getRootPath() ?>"><i class="icon-fire"></i><span> Popular</span></a></li>
						<li class="<?php echo $this->name == 'personal' ? 'active' : '' ?>"><a href="<?php echo $this->app->getRootPath() ?>personal"><i class="icon-star"></i><span> Personal</span></a></li>
					</ul>

					<ul class="nav pull-right">
						<?php if ( $this->app->getSingleton('session')->get('id') ): ?>
						<li class="<?php echo $this->name == 'feeds'   ? 'active' : '' ?>"><a href="<?php echo $this->app->getRootPath() ?>feeds"><i class="icon-align-justify"></i><span> Manage feeds</span></a></li>
						<li class="<?php echo $this->name == 'signout' ? 'active' : '' ?>"><a href="<?php echo $this->app->getRootPath() ?>signout"><i class="icon-off"></i><span> Sign out</span></a></li>
						<?php else: ?>
						<li class="<?php echo $this->name == 'signup'  ? 'active' : '' ?>"><a href="<?php echo $this->app->getRootPath() ?>signup"><i class="icon-user"></i><span> Create account</span></a></li>
						<li class="<?php echo $this->name == 'signin'  ? 'active' : '' ?>"><a href="<?php echo $this->app->getRootPath() ?>signin"><i class="icon-hand-right"></i><span> Sign in</span></a></li>
						<?php endif ?>
					</ul>
				</div>
			</div><!-- /navbar-inner -->
		</header><!-- /navbar -->

		<div class="container">
