<?php get_header(); ?>
    <div class="clearfix row offset-top-60 offset-bottom-20">
    <?php
    global $more;
    while( have_posts() ) : the_post();
    $more = 1; // отображаем полностью всё содержимое поста
    ?>
        <h1><?php the_title() ?></h1>
    <?php endwhile; ?>
        <div class="news-info">
            <div class="news-txt">
                <?php the_field('show_title'); ?>
                <p class="signature">
                    Бразильское шоу, танец живота и световое танцевальное шоу в СПб.<br>
                    Заказ шоу <a href="tel:+79817752781">+7 (981) 775-27-81</a> (Ксения)<br>
                    #exotic_art_show
                </p>
            </div>
            <a target="_blank" href="<?php echo first_post_image() ?>" class="news-img one-img">
                <img src="<?php echo first_post_image() ?>" alt="Exotic Art — <?php the_title(); ?>">
            </a>
        </div>
    </div>

<?php $str= get_the_content();
preg_match_all('/src="([^"]+)"/i', $str, $matches);
$img_urls = $matches[1]; ?>
<?php if($img_urls) { ?>
    <ul class="xsmall-grid-1 medium-grid-2 large-grid-3 show-gallery">
        <?php unset($img_urls[0]); ?>
        <? foreach ($img_urls as $img_url) {?>
            <li>
                <a href="<?php echo $img_url; ?>" title="Exotic Art — <?php the_title(); ?>"><img src="<?php echo $img_url; ?>" alt="" /></a>
            </li>
        <?php } ?>
    </ul>
<?php }?>

<?php if( get_field('show_video') ): ?>
    <div class="row with-video">
        <?php the_field('show_video'); ?>
    </div>
<?php endif; ?>
<?php include 'template-parts/light-block.php' ?>
    </main>
    </div>
<?php get_footer(); ?>