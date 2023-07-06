<hr>
<div class="fin">
    <a href="<?php echo home_url(); ?>">
        < Retour à l'accueil</a>
            <a href="<?php echo home_url('/blog'); ?>">Visiter le blog ></a>
</div>
</section>
<footer>
    <section class="footer-content">

        <!-- Logo -->
        <div class="footer-logo logo-shadow">
            <a href="<?php echo home_url(); ?>">
                <?php if (get_theme_mod('logo_image')) : ?>
                    <img src="<?php echo esc_url(get_theme_mod('logo_image')); ?>" alt="Logo de l'entreprise ABC Hypnose">
                <?php else : ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/logo-abc-hypnose.png" alt="Logo de l'entreprise ABC Hypnose">
                <?php endif; ?>
            </a>
        </div> <!-- FIN Logo -->

        <!-- FB + Contact -->
        <div id="social" class="container d-flex align-items-center justify-content-between">

            <!-- Facebook -->
            <div class="footer-social">
                <span>Suivez-moi sur :</span>
                <a href="<?php echo esc_url(get_theme_mod('facebook_url')); ?>" target="_blank" style="color: <?php echo esc_attr(get_theme_mod('facebook_icon_color')); ?>">
                    <i class="fa-brands fa-facebook fa-2xl"></i></a>
            </div> <!-- FIN Facebook -->

            <!-- Contact -->
            <button class="footer-contact">
                <a href="<?php echo esc_url(home_url('/contact')); ?>">Contacter</a>
            </button> <!-- FIN Contact -->

        </div> <!-- FIN FB + Contact -->

        <!-- Menu Footer -->
        <div class="footer-menu">
            <?php
            if (has_nav_menu('footer-menu')) {
                wp_nav_menu(array(
                    'theme_location' => 'footer-menu',
                    'container' => false,
                    'menu_class' => 'footer-menu',
                ));
            }
            ?>
        </div>

    </section> <!-- FIN footer-content -->
</footer>

<?php wp_footer() ?>

</body>

</html>