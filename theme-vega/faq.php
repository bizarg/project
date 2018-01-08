<?php
/*
Template Name: faq
*/
?>
<?php get_header(); ?>
		<main class="main faq">
			<div class="title-banner">
				<img src="<?php bloginfo('template_url');?>/img/pages-title-bg.jpg" alt="title-image">
				<div class="title-banner-info">
					<h2>FAQ</h2>
					<ul class="breadcrumbs">
						<li><a href="#">Главная</a></li>
						<li>FAQ</li>
					</ul>
				</div><!-- /title-banner-info -->
			</div><!-- /title-banner -->
			<div class="faq-section">
				<div class="content">
					<div class="page-description">
						<h3>часто задаваемые вопросы</h3>
						<p>Уважаемые друзья!<br>
							В этом разделе Вы найдёте ответы на наиболее часто задаваемые вопросы о мебели и сотрудничестве с Вега, а также советы,<br>
							которые помогут Вам сделать правильный выбор и оформить заказ на изготовление мебели. <br>
							Если Вы не нашли интересующую Вас информацию, можете воспользоваться формой связи, нажав на кнопку «задать свой вопрос».</p>
							<a href="#" class="btn">задать свой вопрос</a>
					</div><!-- //page-description -->
					<ul class="faq-list">

                        <?php
//                        $ourCurrentPage = get_query_var('paged');

                        $args = array(
                            'posts_per_page' => '3',
                            'post_type' => ['faq'],
//                            'paged' => $ourCurrentPage,
                        );

                        $faq = new WP_Query( $args ); ?>


                        <?php if( have_posts() ): ?>
                            <?php while ( $faq->have_posts() ) : $faq->the_post();?>

                                <li>
                                    <strong>
                                        <?php the_title(); ?>
                                    </strong>
                                    <div class="faq-info">
                                        <strong class="title">Ответ</strong>
                                        <p>
                                            <?php the_content()?>
                                        </p>
                                    </div><!-- //faq-info -->
                                </li>

                            <?php endwhile; ?>
                            <?php $args = array(
                                'total'        => $faq->max_num_pages,
                                'prev_next'    => False,
                                'before_page_number' => '<li>',
                                'after_page_number'  => '</li>'
                            );?>

                        <?php endif; ?>

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