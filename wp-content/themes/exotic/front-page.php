<?php get_header(); ?>
<h1 class="hide">Шоу-балет в Санкт-Петербурге</h1>

<div class="banner">
    <img src="/wp-content/themes/exotic/img/video-img.jpg" alt="Шоу-балет на свадьбу">
    <video src="/wp-content/themes/exotic/img/video.mp4" width="100%" autoplay loop muted></video>
    <div class="clearfix">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
             viewBox="0 0 799.9 120" xml:space="preserve" class="triangles left">
        <polygon class="triangle" points="799.9,120 0,120 0,0 "/>
      </svg>
      <svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
           viewBox="0 0 799.9 120" xml:space="preserve" class="triangles right">
        <polygon class="triangle" points="0,120 799.9,120 799.9,0 "/>
      </svg>
    </div>
    <div class="banner-wrapper">
        <div class="bottom"></div>
        <p class="row h1">Запомните свой особенный день надолго</p>
        <p class="row">
            Когда праздник проходит, нам остаются лишь воспоминания.<br>
            Эмоции, красивые фотографии - сделайте свое послевкусие особенным!
        </p>
        <a href="/show" class="button basic inverted">Выбрать номера</a>
    </div>
</div>

<h2 class="row h1 offset-top-60">Репертуар</h2>
<div class="full-row show-items">
    <a href="/show" class="show-link">
        <p class="h2">Ваш праздник — ваш выбор</p>
        <p class="top-line fat inverted">
            Повеселитесь на карнавале<br>
            или почувствуйте на себе<br>
            чары древнего востока
        </p>
        <span class="button white inverted offset-top-20">Выбрать номера</span>
    </a>
    <div class="xsmall-12 large-6 columns">
        <a href="/show/antre" class="show-item">
            <img src="/wp-content/themes/exotic/img/frontpage-show-antre.jpg" alt="Светодиодное шоу">
            <p>Шоу с перьевыми веерами и уникальными световыми костюмами</p>
        </a>
    </div>
    <div class="xsmall-12 large-6 columns">
        <a href="/show/brazil" class="show-item">
            <img src="/wp-content/themes/exotic/img/frontpage-show-samba.jpg" alt="Бразильское шоу">
            <p>Бразильская карнавальная самба с интерактивом</p>
        </a>
    </div>
    <div class="xsmall-12 large-6 columns">
        <a href="/show/red" class="show-item">
            <img src="/wp-content/themes/exotic/img/frontpage-show-red.jpg" alt="Световое шоу">
            <p>Световое восточное шоу с зажигательной концовкой под барабаны</p>
        </a>
    </div>
    <div class="xsmall-12 large-6 columns">
        <a href="/show/gold" class="show-item">
            <img src="/wp-content/themes/exotic/img/frontpage-show-gold.jpg" alt="Танец живота">
            <p>Клубный восточный микс с трюковыми элементами танца живота</p>
        </a>
    </div>
</div>

<!-- Causes -->
<h2 class="row h1 offset-top-60">По-настоящему уникальное шоу</h2>
<div class="cause cause-left">
    <a href="/show/brazil" class="cause-info">
        <p class="cause-title">
            Энергия настоящей<br>
            бразильской карнавальной самбы
        </p>
        <div class="cause-txt">
            <p>
                Мы не танцуем латину, мы не ходим красиво в перьях по сцене — мы танцуем <b>самбу</b>.
            </p>
            <p>
                Погрузитесь в буйство эмоций карнавала!
            </p>
        </div>
    </a>
    <a href="/show/brazil" class="cause-img">
        <img src="/wp-content/themes/exotic/img/cause-camba.jpg" alt="Бразильское шоу на праздник">
    </a>
</div>
<div class="cause cause-right">
    <a href="/show/red" class="cause-info">
        <p class="cause-title">
            Прелесть современного<br>
            профессионального восточного шоу
        </p>
        <div class="cause-txt">
            <p>Забудьте про монетки!</p>
            <p>
                Поразительные прогибы, невероятная работа волосами, световые эффекты и,
                конечно же, всеми любимые тряски.
            </p>
        </div>
    </a>
    <a href="/show/red" class="cause-img">
        <img src="/wp-content/themes/exotic/img/cause-oriental.jpg" alt="Танец живота на праздник">
    </a>
</div>
<!-- Causes end -->

<!-- News -->
<h2 class="row h1 offset-top-60">Новости</h2>
<div class="full-row news-items">




  <?php // Display blog posts on any page @ http://m0n.co/l
  $temp = $wp_query; $wp_query= null;
  $wp_query = new WP_Query(); $wp_query->query('showposts=4&cat=2' . '&paged='.$paged); //showposts=12&cat=-3 количество постов/категория
  while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
    <div class="xsmall-12 medium-6 large-3 columns">
      <a href="<?php the_permalink(); ?>" class="news-item">
        <?php the_post_thumbnail(); ?>
        <span><?php the_title(); ?></span>
      </a>
    </div>
  <?php endwhile; ?>
</div>
<?php wp_reset_postdata(); ?>

<div class="text-center offset-top-30 offset-bottom-60">
    <a href="/news" class="button basic inverted">Все новости</a>
</div>
<!-- News end -->
<?php include 'template-parts/light-block.php' ?>

</main>
</div>

<?php get_footer(); ?>
<script src="/wp-content/themes/exotic/js/frontpage.js"></script>
