<?php

// THEME DU SITE WEB

function montheme_enqueue_styles() {
// Charger lien Bootstrap CSS
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css');
// Charger les polices | Utilisation : font-family: 'Manjari', sans-serif | font-family: 'Zen Maru Gothic', sans-serif;
wp_enqueue_style('polices', 'https://fonts.googleapis.com/css2?family=Manjari:wght@100;400;700&family=Zen+Maru+Gothic:wght@300;400;500;700;900&display=swap');
// Charger lien FontAwesome
    wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');  
// Charger fichier style.css    
    wp_enqueue_style('montheme-style', get_stylesheet_uri());
}
add_action(
    'wp_enqueue_scripts',
    'montheme_enqueue_styles',
);

function montheme_enqueue_scripts() {
// Charger script Bootstrap Javascript
  wp_enqueue_script(
      'bootstrap-js', 
      'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js',
      array('jquery'),
      false,
      true
  );
}
add_action('wp_enqueue_scripts', 'montheme_enqueue_scripts');


// Prise en charge des modèles de pages personnalisés
function custom_page_templates($templates){
  $templates['template-custom.php'] = 'Modèle de base';
  return $templates;
}
add_filter('theme_page_templates', 'custom_page_templates');
  

// Activer le menu de navigation principal
function montheme_register_menus() {
    register_nav_menus(array(
        'primary-menu' => 'Menu principal',
    ));
}
add_action('init', 'montheme_register_menus');


// Activer le menu de navigation secondaire 
function register_footer_menu() {
    register_nav_menu('footer-menu', 'Menu secondaire');
}
add_action('after_setup_theme', 'register_footer_menu');





// INTERFACE WORDPRESS

// Customizer logo (l'utilisateur pourra changer le logo)
function montheme_customize_register_logo($wp_customize)
{
    $wp_customize->add_section('logo_section', array(
        'title' => 'Logo',
        'priority' => 30,
    ));

    $wp_customize->add_setting('logo_image');

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'logo_image', array(
        'label' => 'Logo',
        'section' => 'logo_section',
        'settings' => 'logo_image',
    )));
}
add_action('customize_register', 'montheme_customize_register_logo');


// Customizer image bandeau (l'utilisateur pourra changer l'image du bandeau)

function montheme_customize_register_bandeau($wp_customize)
{
    $wp_customize->add_section('bandeau_section', array(
        'title' => 'Bandeau',
        'priority' => 30,
    ));

    $wp_customize->add_setting('bandeau_image');

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'bandeau_image', array(
        'label' => 'Image du bandeau',
        'section' => 'bandeau_section',
        'settings' => 'bandeau_image',
    )));
}
add_action('customize_register', 'montheme_customize_register_bandeau');


// Customiser le footer 

function theme_customizer_footer($wp_customize) 
{
// Section du footer
    $wp_customize->add_section('footer_section', array(
      'title' => 'Footer',
      'priority' => 30,
    ));
  
// Champ pour l'adresse web de la page Facebook
    $wp_customize->add_setting('facebook_url', array(
      'default' => '',
      'sanitize_callback' => 'esc_url_raw',
    ));
  
    $wp_customize->add_control('facebook_url', array(
      'type' => 'url',
      'section' => 'footer_section',
      'label' => 'Adresse web de la page Facebook',
      'description' => 'Entrez l\'adresse web de votre page Facebook.',
    ));

// Champ pour la couleur de l'icône Facebook
$wp_customize->add_setting('facebook_icon_color', array(
    'default' => '#3b5998',
    'sanitize_callback' => 'sanitize_hex_color',
  ));

  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'facebook_icon_color', array(
    'section' => 'footer_section',
    'label' => 'Couleur de l\'icône Facebook',
    'description' => 'Sélectionnez la couleur de l\'icône Facebook.',
  )));

// Champ pour la couleur du bouton "Contacter"
    $wp_customize->add_setting('contact_button_color', array(
      'default' => '#000000',
      'sanitize_callback' => 'sanitize_hex_color',
    ));
  
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'contact_button_color', array(
      'section' => 'footer_section',
      'label' => 'Couleur du bouton "Contacter"',
      'description' => 'Sélectionnez la couleur du bouton "Contacter".',
    )));
  
// Champ pour l'image du logo
    $wp_customize->add_setting('footer_logo', array(
      'default' => '',
      'sanitize_callback' => 'esc_url_raw',
    ));
  
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'footer_logo', array(
      'section' => 'footer_section',
      'label' => 'Image du logo',
      'description' => 'Sélectionnez l\'image du logo du footer.',
    )));
  }
  add_action('customize_register', 'theme_customizer_footer');
  

// BLOG
// Ajout colonne interface edition d'articles
add_filter('manage_posts_columns', function ($columns){
  return[
      'cb' => $columns['cb'],
      'thumbnail' => 'Miniature',
      'title' => $columns['title'],
      'comments' => 'Commetaires',
      'date' => $columns['date']
  ];
});

// Ajout des infos à l'intérieur de la colonne
add_filter('manage_posts_custom_column', function ($column, $postId){
if ($column === 'thumbnail') {
  the_post_thumbnail('thumbnail', $postId);
}
}, 10, 2); // priorité à 10 | nbr paramètres 2 

// Ajout de la possibilité de séletionner une image  
function enable_post_thumbnail() {
  add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'enable_post_thumbnail');
