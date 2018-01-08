<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Вега</title>
	<meta name="viewport" content="width=device-width, initial-scale=1"><!-- responsive -->
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700italic,700,800,800italic' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
	<?php if ( current_user_can('manage_options')): ?>
        <style>
            #header {
                margin-top: 30px;
            }
        </style>
    <?php endif;?>
    }
    ?>
	<?php wp_head(); ?>
</head>
<body>
	<div class="w1">
		<section class="wrapper">
			<header id="header">
				<div class="header-top">
					<div class="content">
						<div class="social">
							<span>Присоединяйся к нам:</span>
							<ul>
								<li class="vk">
									<a href="#"></a>
								</li>
								<li class="inst">
									<a href="#"></a>
								</li>
							</ul>
						</div><!-- /social-->
						<i class="fa fa-bars navigation-opener"></i>
						<nav>
							<?php dynamic_sidebar('menu_header'); ?>
						</nav>
					</div><!-- /content  -->
				</div><!-- /header-top -->
				<div class="header-middle">
					<div class="content">
						<div class="add-links">
							<ul>
								<li class="gallery">
									<a href="#"><span>Галерея</span></a>
								</li>
								<li class="sales">
									<a href="#"><span>Распродажа</span></a>
								</li>
								<li class="action">
									<a href="#"><span>Акции</span></a>
								</li>
							</ul>
						</div><!-- /social-->
						<h1 class="logo"><a href="index.html">Вега</a></h1>
						<a href="#" class="btn"><span>Вызвать замерщика</span><i class="fa fa-phone"></i></a>
						<div class="contact">
							<span class="contact-opener"><i class="fa fa-map-marker"></i><span>Контакты</span></span>
							<ul>
								<li class="gallery">
									<span class="city">г. Кисловодск</span>
									<a href="tel:+79280074040">+7 928 <strong>007-40-40</strong></a>
									<span class="info">ул. Горького, 3</span>
								</li>
								<li class="gallery">
									<span class="city">г. Ессентуки</span>
									<a href="tel:+79280074040">+7 928 <strong>007-45-45</strong></a>
									<span class="info">ул. Кисловодская, 25</span>
								</li>
							</ul>
						</div><!-- /contact-->
					</div><!-- /content  -->
				</div><!-- /header-middle -->
			</header><!-- /header -->