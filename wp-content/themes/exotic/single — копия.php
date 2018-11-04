<?php
$post = $wp_query->post;

if (in_category('32')) { //ID категории
    include('/wp-content/themes/exotic/single3.php');
} else {
    include(TEMPLATEPATH.'/single3.php');
}
?>


<?php get_header(); ?>
    <div class="clearfix">
        <div class="cause cause-left not-link">
            <?php
            global $more;
            while( have_posts() ) : the_post();
            $more = 1; // отображаем полностью всё содержимое поста
            ?>
            <div class="cause-info not-link">
                <div class="cause-title">
                    <h1><?php the_title() ?></h1>
                    <?php endwhile; ?>
                    <?php if( get_field('show_video') ): ?>
                        <a href="#video" class="button white inverted small js-link">Смотреть видео</a>

                    <?php endif; ?>
                </div>
                <div class="cause-txt">
                    <p>
                        <?php the_field('show_title'); ?>
                    </p>
                    <?php if( get_field('show_time') ): ?>
                        <p class="description"><?php the_field('show_time') ?></p>

                    <?php endif; ?>
                </div>

            </div>

            <div class="cause-img not-link">
                <img src="<?php echo first_post_image() ?>" alt="Exotic Art — <?php the_title(); ?>">
            </div>
        </div>
    </div>

<?php $str= get_the_content();
preg_match_all('/src="([^"]+)"/i', $str, $matches);
$img_urls = $matches[1]; ?>
<?php if($img_urls) { ?>
    <ul class="xsmall-grid-1 medium-grid-2 large-grid-3 show-gallery offset-top-20">
        <?php unset($img_urls[0]); ?>
        <? foreach ($img_urls as $img_url) {?>
            <li>
                <a href="<?php echo $img_url; ?>" title="Exotic Art — <?php the_title(); ?>"><img src="<?php echo $img_url; ?>" alt="" /></a>
            </li>
        <?php } ?>
    </ul>
<?php }?>

<?php if( get_field('show_video') ): ?>
    <h2 id="video" class="row offset-top-40">Видео номера</h2>
    <div class="row with-video">
        <?php the_field('show_video'); ?>
    </div>
<?php endif; ?>
<?php include 'template-parts/light-block.php' ?>
    </main>
    </div>
<?php get_footer(); ?>