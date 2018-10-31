<?php
/*
Template Name: Show
*/
?>
<?php get_header(); ?>
<h1 class="row h1 offset-top-60"><?php echo get_the_title() ?></h1>

<div class="row show-items large-show">
	<?php // Display blog posts on any page @ http://m0n.co/l
	$temp = $wp_query; $wp_query= null;
	$wp_query = new WP_Query(); $wp_query->query('showposts=20&cat=3' . '&paged='.$paged); //showposts=12&cat=-3 количество постов/категория
	while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
      <div class="xsmall-12 medium-6 columns">
        <a href="<?php the_permalink(); ?>" class="show-item">
			    <?php the_post_thumbnail(); ?>
          <p class="title"><?php the_title(); ?></p>
          <p><?php the_excerpt() ?></p>
        </a>
      </div>
	<?php endwhile; ?>
</div>
<?php wpexotic_pagination(); ?>
<?php wp_reset_postdata(); ?>

</div>

<h2 class="row offset-top-60">Эксклюзивные номера для вашего праздника</h2>
<div class="row show-items large-show">
	<?php // Display blog posts on any page @ http://m0n.co/l
	$temp = $wp_query; $wp_query= null;
	$wp_query = new WP_Query(); $wp_query->query('showposts=20&cat=4' . '&paged='.$paged); //showposts=12&cat=-3 количество постов/категория
	while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
      <div class="xsmall-12 medium-6 columns">
        <a href="<?php the_permalink(); ?>" class="show-item">
			<?php the_post_thumbnail(); ?>
          <p class="title"><?php the_title(); ?></p>
          <p><?php the_excerpt() ?></p>
        </a>
      </div>
	<?php endwhile; ?>
</div>
<?php wpexotic_pagination(); ?>
<?php wp_reset_postdata(); ?>
</div>

<?php include 'template-parts/light-block.php' ?>

</main>

</div>
<?php get_footer(); ?>
