<?php get_header(); ?>
<h1><?php echo get_the_title(get_option('page_for_posts')); ?></h1>

<div class="blog-container">
  <div class="row">
    <?php if (have_posts()) : ?>
      <?php while (have_posts()) : the_post(); ?>
        <div class="col-md-6">
          <div class="blog-post">

            <div class="post-image">
              <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('medium'); ?>
              <?php endif; ?>
            </div>

            <div class="post-divider">
              <span class="fa-stack fa-xl">
                <i class="fas fa-circle fa-stack-2x" style="color: #68726c;"></i>
                <i class="fas fa-pen fa-stack-1x" style="color: #fff;"></i>
              </span>
            </div>

            <div class="post-content">
              <h2 class="post-title"><?php the_title(); ?></h2>

              <div class="post-meta">
                <span class="comment-count"><i class="fas fa-comment" style="color: #68726c;"></i><?php echo get_comments_number(); ?> </span>
              </div>


              <div class="entry-content">
                <?php the_excerpt(); ?>
                <a href="<?php the_permalink(); ?>" class="read-more">Lire la suite</a>
              </div><!-- .entry-content -->


            </div>
            <br>

          </div> <!-- FIN Blog-Post -->
        </div>
      <?php endwhile; ?>
    <?php else : ?>
      <p>Aucun article trouvé.</p>
    <?php endif; ?>
  </div> <!-- FIN row -->
</div> <!-- FIN blog-container -->

<?php get_footer(); ?>