<?php
/*
Template Name: Modèle de base
Template Post Type: Page
*/
?>

<?php get_header(); ?>

<?php
if (have_posts()) {
  while (have_posts()) {
    the_post();
    the_content();
  }
}
?>

<?php get_footer(); ?>
