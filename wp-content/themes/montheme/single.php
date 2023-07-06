<?php get_header();
  while (have_posts()) {
  the_post();
?>

  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <h1><?php the_title(); ?></h1>
   
    <div class="post-content">
      <?php the_content(); ?>
    </div>

  </article>

  <?php comments_template(); ?>


<?php
}

get_footer();
