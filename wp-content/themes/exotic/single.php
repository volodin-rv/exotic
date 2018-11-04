<?php
$post = $wp_query->post;

if (in_category('news')) { //ID категории
    include(TEMPLATEPATH.'/single-news.php');
} else if (in_category('show' || 'exclusive' )) {
    include(TEMPLATEPATH.'/single-show.php');
}
?>