<?php
add_filter( 'jpeg_quality', create_function( '', 'return 100;' ) );

function wpexotic_setup() {

    load_theme_textdomain(wpexotic);

    add_theme_support('title-tag');

    add_theme_support('custom-logo', array(
        'height' => 57,
        'width' => 348,
        'flex-height' => true
    ));

    add_theme_support( 'post-thumbnails');
    set_post_thumbnail_size(900, 900);

    add_theme_support('html5', array(
        'search_form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption'
    ));

    add_theme_support('post-formats', array(
       'aside',
       'image',
       'video',
       'gallery',
        'link'
    ));

  register_nav_menu('primary', 'Primary menu');
}
add_action('after_setup_theme', 'wpexotic_setup');

function wpexotic_scripts() {
    // регистрация jQuery
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js', false, null, true );
    wp_enqueue_script( 'jquery' );

    // подключаем файлы стилей темы
    wp_enqueue_style( 'style.css', get_stylesheet_uri() );
    wp_enqueue_style( 'style', get_template_directory_uri() . '/css/style.css');

    // подключаем js файлы
    wp_enqueue_script( 'js', get_template_directory_uri() .'/js/jquery.min.js', array(), '1.0', true );
    wp_enqueue_script( 'header', get_template_directory_uri() .'/js/header.js', array(), '1.0', true );
    wp_enqueue_script( 'frontpage', get_template_directory_uri() .'/js/frontpage.js', array(), '1.0', true );
    wp_enqueue_script( 'popup', get_template_directory_uri() .'/js/jquery.magnific-popup.min.js', array(), '1.0', true );
    wp_enqueue_script( 'for-view', get_template_directory_uri() .'/js/for-view.js', array(), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'wpexotic_scripts' );

/**
 * Pagination
 */
function wpexotic_pagination( $args = array() ) {

  $defaults = array(
    'range'           => 4,
    'custom_query'    => FALSE,
    'previous_string' => esc_html__( '', 'wptuts' ),
    'next_string'     => esc_html__( '', 'wptuts' ),
    'before_output'   => '<div class="row"><ul class="pagination">',
    'after_output'    => '</ul></div>'
  );

  $args = wp_parse_args(
    $args,
    apply_filters( 'wp_bootstrap_pagination_defaults', $defaults )
  );

  $args['range'] = (int) $args['range'] - 1;
  if ( !$args['custom_query'] )
    $args['custom_query'] = @$GLOBALS['wp_query'];
  $count = (int) $args['custom_query']->max_num_pages;
  $page  = intval( get_query_var( 'paged' ) );
  $ceil  = ceil( $args['range'] / 2 );

  if ( $count <= 1 )
    return FALSE;

  if ( !$page )
    $page = 1;

  if ( $count > $args['range'] ) {
    if ( $page <= $args['range'] ) {
      $min = 1;
      $max = $args['range'] + 1;
    } elseif ( $page >= ($count - $ceil) ) {
      $min = $count - $args['range'];
      $max = $count;
    } elseif ( $page >= $args['range'] && $page < ($count - $ceil) ) {
      $min = $page - $ceil;
      $max = $page + $ceil;
    }
  } else {
    $min = 1;
    $max = $count;
  }

  $echo = '';
  $previous = intval($page) - 1;
  $previous = esc_attr( get_pagenum_link($previous) );

  if ( $previous && (1 != $page) )
    $echo .= '<li class="prev"><a href="' . $previous . '" title="' . esc_html__( 'previous', 'wptuts') . '">' . $args['previous_string'] . '</a></li>';

  if ( !empty($min) && !empty($max) ) {
    for( $i = $min; $i <= $max; $i++ ) {
      if ($page == $i) {
        $echo .= '<li class="active"><span>' . str_pad( (int)$i, 1, '0', STR_PAD_LEFT ) . '</span></li>';
      } else {
        $echo .= sprintf( '<li><a href="%s" >%2d</a></li>', esc_attr( get_pagenum_link($i) ), $i );
      }
    }
  }

  $next = intval($page) + 1;
  $next = esc_attr( get_pagenum_link($next) );
  if ($next && ($count != $page) )
    $echo .= '<li class="next"><a href="' . $next . '" title="' . esc_html__( 'next', 'wptuts') . '">' . $args['next_string'] . '</a></li>';
  if ( isset($echo) )
    echo $args['before_output'] . $echo . $args['after_output'];
}

//Первое изображение записи
function first_post_image() {
	global $post, $posts;
	$first_img = '';
	ob_start();
	ob_end_clean();
	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
	$first_img = $matches [1] [0];
	if(empty($first_img)){
		$first_img = "/wp-content/themes/НАЗВАНИЕТЕМЫ/images/noimages.jpg";
// укажите путь к изображению, которое будет выводится по умолчанию.
	}
	return $first_img;
}
