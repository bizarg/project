<?php get_header(); ?>
			<main class="main home">
				<div class="home-slider">
					<img src="<?php bloginfo('template_url');?>/img/slider-bg.jpg" alt="slider-bg">
					<div class="content">
						<div class="slider-description">
							<h2 class="underline white-underline">Мебель<br>под заказ</h2>
							<strong class="slogan">Воплощаем мечты!</strong>
							<p>
								Наша мебельная продукция производится на современном оборудовании с применением новейших технологий и не имеет аналогов по соотношению цены и качества. Компания Вега гарантирует высочайшее качество мебельной продукции, долгий срок службы и оригинальность фурнитуры от лучших производителей.
							</p>
							<p>
								Для наших покупателей мы предоставляем рассрочку оплаты готовых изделий, а постоянным клиентам делаем хорошие скидки.
							</p>
							<a href="#" class="btn white-btn ico-btn ico-gallery">Смотреть галерею</a>
						</div><!-- /slider-description -->
						<ul class="slick-slider">
							<li>
								<img src="<?php bloginfo('template_url');?>/img/slider-img-01.jpg" alt="slider-image-01">
							</li>
							<li>
								<img src="<?php bloginfo('template_url');?>/img/slider-img-01.jpg" alt="slider-image-01">
							</li>
							<li>
								<img src="<?php bloginfo('template_url');?>/img/slider-img-01.jpg" alt="slider-image-01">
							</li>
						</ul>
						<a href="#home-gallery" class="scroll-bottom"></a>
					</div><!-- /content  -->
				</div><!-- /home-slider -->
				<section class="home-gallery" id="home-gallery">
					<h3 class="title">
						Галерея Выполненных работ
						<span><a href="#"><span>Смотреть все работы</span></a></span>
					</h3>
					<ul class="gallery-slider">
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						<li>
							<div class="slide-box">
								<?php the_post_thumbnail(); ?>
								<div class="slider-description">
									<div class="slider-description-vertical">
										<h3 class="underline red-underline"><?php the_title(); ?></h3>
										<?php the_excerpt(); ?>
										<a href="#" class="btn ico-btn ico-gallery">Смотреть галерею</a>
									</div><!-- /slider-description-vertical -->
								</div><!-- /slider-description -->
							</div><!-- /slide-box -->
						</li>
					<?php endwhile; ?>
					<?php endif;?>

					</ul>
				</section><!-- /home-gallery -->
				<div class="about-us">
					<div class="content">
						<ul>
							<li class="car">
								<strong class="title">Работаем по всей россии</strong>
								<p>Доставка в любую<br> точку России</p>
							</li>
							<li class="hope">
								<strong class="title">Воплощаем мечты</strong>
								<p>Индивидуальный дизайн<br> по Вашему заказу</p>
							</li>
							<li class="price">
								<strong class="title">Досутпые цены</strong>
								<p>Качество по<br> приемлемой цене</p>
							</li>
							<li class="time">
								<strong class="title">Удобное время</strong>
								<p>Производство под заказ<br>в удобное для Вас время</p>
							</li>
						</ul>
					</div><!-- /content -->
				</div><!-- /about-us -->
				<section class="sales">
					<div class="content">
						<h3 class="title">
							Распродажа мебели
							<span><a href="#"><span>Смотреть все товары</span></a></span>
						</h3>
						<ul class="sales-slider">
							<li>
								<div class="slide-box">
									<a href="#">
										<img src="<?php bloginfo('template_url');?>/img/sales-img-01.jpg" alt="sales-img01">
									</a>
									<div class="description">
										<strong><a href="#">Метод/Сэведаль</a></strong>
										<span class="name">Кухня</span>
										<span class="price"><span class="price-regular">45 990.-</span><span class="old-price">45 990.-</span></span>
										<a href="#" class="more-info"></a>
									</div><!-- /description -->
								</div><!-- /slide-box -->
							</li>
							<li>
								<div class="slide-box">
									<a href="#">
										<img src="<?php bloginfo('template_url');?>/img/sales-img-02.jpg" alt="sales-img01">
									</a>
									<div class="description">
										<strong><a href="#">Метод/Сэведаль</a></strong>
										<span class="name">Кухня</span>
										<span class="price"><span class="price-regular">45 990.-</span><span class="old-price">45 990.-</span></span>
										<a href="#" class="more-info"></a>
									</div><!-- /description -->
								</div><!-- /slide-box -->
							</li>
							<li>
								<div class="slide-box">
									<a href="#">
										<img src="<?php bloginfo('template_url');?>/img/sales-img-03.jpg" alt="sales-img01">
									</a>
									<div class="description">
										<strong><a href="#">Метод/Сэведаль</a></strong>
										<span class="name">Кухня</span>
										<span class="price"><span class="price-regular">45 990.-</span><span class="old-price">45 990.-</span></span>
										<a href="#" class="more-info"></a>
									</div><!-- /description -->
								</div><!-- /slide-box -->
							</li>
						</ul>
					</div><!-- /content -->
				</section><!-- /sales -->
				<section class="news">
					<div class="content">
						<h3 class="title">
							новости и акции
							<span><a href="#"><span>смотерть все новости и акции</span></a></span>
						</h3>
						<div class="new-box">
							<div class="news-banner">
								<a href="#"><img src="<?php bloginfo('template_url');?>/img/action-image.jpg" alt="action-image"></a>
								<div class="description">
									<span class="date">18 апреля 2016</span>
									<span class="action">акция</span>
									<h3><a href="">Идейные соображения высшего порядка</a></h3>
									<p>
										Повседневная практика показывает, что постоянный количественный рост и сфера нашей активности обеспечивает широкому кругу.
									</p>
									<div class="btns">
										<a href="#" class="btn white-btn">подробнее</a>
										<a href="#" class="line-link">Все акции</a>
									</div><!-- /btns -->
								</div>
							</div><!-- /news-banner -->
							<ul class="home-news">
								<li>
									<a href="#"><img src="<?php bloginfo('template_url');?>/img/home-news-img01.jpg" alt="home-news-img01"></a>
									<div class="description">
										<span class="date">18 апреля 2016</span>
										<span class="new">новость</span>
										<h4><a href="#">Идейные соображения<br>высшего порядка</a></h4>
										<p>Повседневная практика показывает, что постоянный количественный рост и сфера нашей активности обеспечивает широкому кругу.</p>
										<a href="#" class="line-link">подробнее</a>
									</div>
								</li>
								<li>
									<a href="#"><img src="<?php bloginfo('template_url');?>/img/home-news-img02.jpg" alt="home-news-img02"></a>
									<div class="description">
										<span class="date">18 апреля 2016</span>
										<span class="new">новость</span>
										<h4><a href="#">Идейные соображения<br>высшего порядка</a></h4>
										<p>Повседневная практика показывает, что постоянный количественный рост и сфера нашей активности обеспечивает широкому кругу.</p>
										<a href="#" class="line-link">подробнее</a>
									</div>
								</li>
								<li>
									<a href="#"><img src="<?php bloginfo('template_url');?>/img/home-news-img03.jpg" alt="home-news-img03"></a>
									<div class="description">
										<span class="date">18 апреля 2016</span>
										<span class="new">новость</span>
										<h4><a href="#">Идейные соображения<br>высшего порядка</a></h4>
										<p>Повседневная практика показывает, что постоянный количественный рост и сфера нашей активности обеспечивает широкому кругу.</p>
										<a href="#" class="line-link">подробнее</a>
									</div>
								</li>

							</ul>
						</div><!-- /new-box -->
					</div><!-- /content -->
				</section><!-- /news -->
			</main><!-- /main -->
		</section><!-- /wrapper -->
	</div><!-- /w1 -->
	
	<?php get_footer(); ?>
