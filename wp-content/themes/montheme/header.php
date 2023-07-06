<!DOCTYPE html>

<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <?php wp_head(); ?>
</head>

<body>

    <header class="navbar<?php if (
                            has_nav_menu('primary-menu')
                            && isset($_GET['menu_clicked'])
                          )
                            echo ' menu-open'; ?>">

      <section class="container d-flex align-items-start justify-content-between">

        <!-- Logo -->
        <div class="logo logo-shadow">
          <a href="<?php echo home_url(); ?>">

            <?php if (get_theme_mod('logo_image')) : ?>
              <img src="<?php echo esc_url(get_theme_mod('logo_image')); ?>" 
              alt="Logo de l'entreprise ABC Hypnose">
              
            <?php else : ?>
              <img src="<?php echo get_template_directory_uri(); ?>/images/logo-abc-hypnose.png" 
              alt="Logo de l'entreprise ABC Hypnose">
            <?php endif; ?>

          </a>
        </div> <!-- FIN Logo -->

        <!-- Téléphone -->
        <div class="d-flex justify-content-end align-item-center" id="tel">
          <div id="fa-phone">
            <i class="fa-solid fa-phone fa-sm"></i>
          </div>
          <p>06 75 75 07 86</p>
        </div>

        <!-- Menu -->
        <div class="menu">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu-content" aria-controls="menu-content" aria-expanded="false" aria-label="Toggle navigation">

            <span class="navbar-toogler-icon">
              <i class="fas fa-bars fa-xl text-white"></i>
            </span>

          </button>

          <div class="collapse navbar-collapse justify-content-end" id="menu-content">
            <?php wp_nav_menu(array(
              'theme_location' => 'primary-menu',
              'menu_class' => 'navbar-nav'
            )); ?>
          </div>

        </div> <!-- FIN Menu -->


      </section> <!-- FIN .container | Contenu du header -->
    </header>


    <!-- Image bandeau -->
    <?php $bandeau_image = get_theme_mod('bandeau_image'); ?>
    <div class="bandeau">
      <?php if (!empty($bandeau_image)) : ?>
        <img src="<?php echo esc_url($bandeau_image); ?>" alt="Image du bandeau">
      <?php else : ?>
        <img src="<?php echo get_template_directory_uri() . '/images/hypnose-pierres-eau-ondulation.jpg'; ?>" alt="Image du bandeau par défaut">
      <?php endif; ?>
    </div>



    <!-- Lien vers le haut de la page -->
    <a href="#top" id="scroll-top">
      <div class="cercle">
        <div class="triangle"></div>
      </div>
    </a>

    <section id="contenu-principal" >
    <!--class="flex col-md-8 offset-md-2 align-items-center justify-content-center">-->