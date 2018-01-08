<?php

/**
* загружаемые скрипты и стили
*/
function load_style_script() {
	wp_enqueue_script('jquery_my ', get_template_directory_uri() .
	'/js/jquery-2.2.1.min.js');
	wp_enqueue_script('slick', get_template_directory_uri() .
	'/js/slick.js');
	wp_enqueue_script('main', get_template_directory_uri() .
	'/js/main.js');
	
	wp_enqueue_style('style', get_template_directory_uri() . '/style.css');
	wp_enqueue_style('font_style', get_template_directory_uri() . '/css/font-awesome.min.css');
}

/**
* загружаем скрипты и стили
*/
add_action('wp_enqueue_scripts', 'load_style_script');

/**
*Добавляем виджеты
*/
register_sidebar(array(
	'name' => 'Меню',
	'id' => 'menu_header',
	'before_widget' => '',
	'after_widget' => ''
));

/**
*Добавляем виджеты
*/
register_sidebar(array(
	'name' => 'Footer gallery',
	'id' => 'footer_gallery',
	'before_widget' => '',
	'after_widget' => ''
));

register_sidebar(array(
	'name' => 'pre-footer',
	'id' => 'partners',
	'before_widget' => '',
	'after_widget' => '',
));

/**
*поддержка миниатюр
*/
add_theme_support('post-thumbnails');
//set_post_thumbnail_size(464, 667);


add_action( 'init', 'prowp_register_my_post_types' );
function prowp_register_my_post_types() {
    register_post_type( 'faq',
        [
            'labels' => [
                'name' => 'FAQ'
            ],
            'public' => true,
            'supports' => ['title', 'editor', 'author', 'thumbnail', 'comments' ],
            'rewrite' => [
                'slug' => 'hint',
	            'with_front' => false,
	            'feeds' => false,
	            'pages' => true,
	            'ep_mask' => 'константа',
            ],
        ]
    );

    register_post_type( 'reviews',
        array(
            'labels' => array(
                'name' => 'Rewiews'
            ),
            'public' => true,
            'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'comments' ),
        )
    );
}

//function prowp_register_my_post_types() {
//    $args = array(
//        'public' => true,
//        'has_archive' => true,
//        'taxonomies' => array( 'category' ),
//        'rewrite' => array( 'slug' => 'product' ),
//        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'comments' )
//    );
//    register_post_type( 'products', $args );
//}
