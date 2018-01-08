<?php
/*
Template Name: reviews
*/
?>
<?php get_header(); ?>
		<main class="main reviews">
				<div class="title-banner">
					<img src="<?php bloginfo('template_url');?>/img/pages-title-bg.jpg" alt="title-image" alt="title-image">
					<div class="title-banner-info">
						<h2>Отзывы</h2>
						<ul class="breadcrumbs">
							<li><a href="#">Главная</a></li>
							<li>Отзывы</li>
						</ul>
					</div><!-- /title-banner-info -->
				</div><!-- /title-banner -->
				<div class="faq-section">
					<div class="content">
						<div class="page-description">
							<h3>о нас говорят</h3>
							<p>
								Здесь Вы можете ознакомится с отзывами наших клиентов, а так же написать свой отзыв. Нам важно Ваше мнение!
							</p>
							<a href="#" class="btn">написать отзыв</a>
						</div><!-- //page-description -->
						<ul class="reviews-list">
                            <?php
                            $args = array(
                                'posts_per_page' => '3',
                                'post_type' => 'reviews',
                            );

                            $reviews = new WP_Query( $args );?>

                            <?php while ( $reviews->have_posts() ) : $reviews->the_post();?>

                                <li>
                                    <div class="autor-info">
                                        <img src="<?php bloginfo('template_url');?>/img/avatar.png" alt="slider-image-01" alt="avatar">
                                        <span class="date"><?php echo date_i18n( 'j F Y', strtotime( time() ) ); ?></span>
                                        <strong class="name"><?php the_author(); ?></strong>
                                        <span class="city">г.Кисловодск</span>
                                    </div><!-- //autor-info-->
                                    <div class="reviews-text-prew">
                                        <p>
                                            <?php the_title(); ?>
                                        </p>
                                    </div><!-- //reviews-text-prew-->
                                    <div class="reviews-text-all">
                                        <?php the_content(); ?>
                                    </div><!-- //reviews-text-all -->
                                </li>

                                <?php endwhile; ?>
                            <?php $args = array(
                                'total'        => $reviews->max_num_pages,
                                'prev_next'    => False,
                                'before_page_number' => '<li>',
                                'after_page_number'  => '</li>'
                            );?>
                            <?php wp_reset_postdata();?>

						</ul>
					</div><!-- /content -->
                    <div class="pages-navigation">
                        <div class="content">
                            <ul>
                                <?php echo paginate_links( $args ); ?>
                            </ul>
                        </div><!-- /content -->
                    </div><!-- /pages-navigation -->
				</div><!-- /faq -->
			</main><!-- /main -->
		</section><!-- /wrapper -->
	</div><!-- /w1 -->
	<?php get_footer(); ?>
</body>
</html>