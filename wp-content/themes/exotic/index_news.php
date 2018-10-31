<?php
/*
Template Name: News
*/
?>

<?php get_header(); ?>
  <h1 class="row offset-top-60"><?php echo get_the_title() ?></h1>
  <div class="row news-items">
      <?php // Display blog posts on any page @ http://m0n.co/l
      $temp = $wp_query; $wp_query= null;
      $wp_query = new WP_Query(); $wp_query->query('showposts=12&cat=2' . '&paged='.$paged); //showposts=12&cat=-3 количество постов/категория
      while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
        <div class="xsmall-12 medium-6 large-4 columns">
          <a href="<?php the_permalink(); ?>" class="news-item">
            <?php the_post_thumbnail(); ?>
            <span><?php the_title(); ?></span>
          </a>
        </div>
      <?php endwhile; ?>
  </div>
<?php wpexotic_pagination(); ?>
<?php wp_reset_postdata(); ?>
  </main>

  </div>
<?php get_footer(); ?>