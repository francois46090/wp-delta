<?php 

function styles_complementaires(){
    // Styles CSS
    wp_enqueue_style('polices-google','https://fonts.googleapis.com/css2?family=Open+Sans&family=Unica+One&display=swap');  
    wp_enqueue_style('style-global',get_stylesheet_directory_uri().'/css/global.css');
    wp_enqueue_style('woocommerce-css',get_stylesheet_directory_uri().'/css/woocommerce.css');
    wp_enqueue_style('responsive-css',get_stylesheet_directory_uri().'/css/responsive.css');
}

add_action('wp_enqueue_scripts','styles_complementaires');

//  INITIALISATION DES MENUS

if(function_exists('register_nav_menus')){
    register_nav_menus(
        array(
            'main'=>'Menu principal',
            'topbar'=>'Top Bar Menu',
            'footmenu'=>'Menu dans le footer',
            'secondaire'=>'Menu pages secondaires'
        )
    );
}

/**
 * 1 -Register Custom Navigation Walker
 */
function register_navwalker(){
	require_once get_template_directory() . '/class-wp-bootstrap-navwalker.php';
}
add_action( 'after_setup_theme', 'register_navwalker' );

/* Pour que le menu déroulant fonctionne avec bootstrap 5*/

add_filter( 'nav_menu_link_attributes', 'prefix_bs5_dropdown_data_attribute', 20, 3 );
/**
 * Use namespaced data attribute for Bootstrap's dropdown toggles.
 *
 * @param array    $atts HTML attributes applied to the item's `<a>` element.
 * @param WP_Post  $item The current menu item.
 * @param stdClass $args An object of wp_nav_menu() arguments.
 * @return array
 */
function prefix_bs5_dropdown_data_attribute( $atts, $item, $args ) {
    if ( is_a( $args->walker, 'WP_Bootstrap_Navwalker' ) ) {
        if ( array_key_exists( 'data-toggle', $atts ) ) {
            unset( $atts['data-toggle'] );
            $atts['data-bs-toggle'] = 'dropdown';
        }
    }
    return $atts;
}

// INITIALISATION DES WIDGETS

function theme_sidebar(){

    if(function_exists('register_sidebar')){

        register_sidebar(
            array(
                'id'=>'premier',
                'name'=>'Colonne de gauche',
                'description'=>'Emplacement se trouvant à gauche sur les pages secondaires',
                'before_widget'=>'<div>',
                'after_widget'=>'</div>'
            )
        );
    }

    if(function_exists('register_sidebar')){

        register_sidebar(
            array(
                'id'=>'deux',
                'name'=>'Colonne de droite',
                'description'=>'Emplacement se trouvant à droite sur les pages secondaires',
                'before_widget'=>'<div>',
                'after_widget'=>'</div>'
            )
        );
    }

    if(function_exists('register_sidebar')){

        register_sidebar(
            array(
                'id'=>'trois',
                'name'=>'footer',
                'description'=>'Emplacement se trouvant dans le footer',
                'before_widget'=>'<div>',
                'after_widget'=>'</div>'
            )
        );
    }

}
add_action('widgets_init','theme_sidebar');
// Ajouter la personnalisation du thème
// add_theme_support($custom,$arg)
// 1 - post-formats
// 2 - post-thumbnails
// 3 - custom-background
// 4 - custom-header

function theme_setup(){
    //1- post-formats
    add_theme_support('post-formats',array('aside','gallery','quote','image','link','status','video','audio'));

    // 2 - post-thumbnails
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(800,300,true);

    // 3 - custom-background
    $arg=array(
        'default-color'=>'f1f1f1',
        'default-image'=>'',
        'default-repeat'=>'repeat',
        'default-position'=>'left',
        'wp-head-callback'=>'_custom_background_cb'
    );
    add_theme_support('custom-background',$arg);

    // 4 - custom-header
    $entete = array(
        'default-image'=>'',
        'random-default'=>false,
        'width'=>1200,
        'height'=>400,
        'flex-height'=>false,
        'flex-width'=>false,
        'default-text-color'=>'ff0000',
        'header-text'=>true,
        'uploads'=>true
    );

    add_theme_support('custom-header',$entete);

    add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' ) );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
}

add_action('after_setup_theme','theme_setup');
// PERSONNALISATION DU THEME

function theme_customize_register($wp_customize){
    // creer la section pour les paramètres généraux

    $wp_customize->add_section('ma_section',array(
        'title'=>'Paramètres généraux',
        'description'=>'Description de mon theme',
        'priority'=>130
    ));

    // Affiche ou non le titre des pages et des articles

    // reglage
    $wp_customize->add_setting('active_title',array('default'=>'title','sanitize_callback'=>'esc_attr'));


    //controle

    $wp_customize->add_control('active_title',array(
        'label'=>'Activer ou Desactiver le titre des pages et articles',
        'section'=>'ma_section',
        'settings'=>'active_title',
        'type'=>'select',
        'choices'=>array(
            'title'=>'Afficher le titre',
            'hidden'=>'Desactiver le titre'
        )
    ));

// Fullwidth ou Boxed : Choix de la largeur du site
    // container ou container-fluid (bootstrap)
    // reglage
        $wp_customize->add_setting('largeur_site',array('default'=>'container','sanitize_callback'=>'esc_attr'));


    // controle

        $wp_customize->add_control('largeur_site',array(
            'label'=>'Largeur du site : Fullwidth ou Boxed',
            'section'=>'ma_section',
            'type'=>'select',
            'choices'=>array(
                'container'=>'Boxed',
                'container-fluid'=>'Fullwidth'
            )));


// Selecteur de couleur : LIENS
// 1 - Ajout du réglage
    $wp_customize->add_setting('couleur_liens',array(
        'default'=>'#000',
        'sanitize_callback'=>'sanitize_hex_color',
        'capability'=>'edit_theme_options',
        'type'=>'theme_mod',
        'transport'=>'refresh'
    ));

// 2-  Ajout du contrôle Selecteur de couleur

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'link_color',array(
        'label'=>'Couleur des liens',
        'section' =>'ma_section',
        'settings'=>'couleur_liens'
    )));

    // couleur du texte
         // ajout du reglage
    $wp_customize->add_setting('color_text',array(
            'default'=>'#000000',
            'sanitize_callback'=>'sanitize_hex_color',
            'capability'=>'edit_theme_options',
            'type'=>'theme_mod',
            'transport'=>'refresh'
        ));

    //Ajout du controle
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'color_txt',array(
        'label'=>'Couleur du texte',
        'section' =>'ma_section',
        'settings'=>'color_text'

    )));
    // BACKGROUND
    // IMAGE
    // reglage => settings
        $wp_customize->add_setting('bg_site',array('sanitize_callback'=>'esc_attr'));

    // controle

        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,'background_site',array(
            'label'=>'Fond du site',
            'section'=>'ma_section',
            'settings'=>'bg_site'
        )));

    // Couleur du background

    // ajout du reglage
    $wp_customize->add_setting('color_background',array(
            'default'=>'#ffffff',
            'sanitize_callback'=>'sanitize_hex_color',
            'capability'=>'edit_theme_options',
            'type'=>'theme_mod',
            'transport'=>'refresh'
        ));

    //Ajout du controle
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'color_bg',array(
        'label'=>'Couleur du background',
        'section' =>'ma_section',
        'settings'=>'color_background'

    )));


    //  POSITION DE L'IMAGE / BACKGROUND-POSITION
        // REGLAGE

        $wp_customize->add_setting('body_bg_position',array('default'=>'center center','sanitize_callback'=>'esc_attr'));
        //CONTROLE


        // à gauche en haut (left top)
        // a gauche en bas ( left bottom)
        // au centre ( center center)
        // a droite en haut (right top)
        //a droite en bas (right bottom)

        $wp_customize->add_control('body_bg_position',array(
        'label'=>'Position de l\'image de fond',
        'section'=>'ma_section',
        'settings'=>'body_bg_position',
        'type'=>'select',
        'choices'=>array(
            'left top'=>'à gauche en haut',
            'left bottom'=>'a gauche en bas',
            'center center'=>'au centre',
            'right top'=>'à droite en haut',
            'right bottom'=>'a droite en bas'
        )));
        

    // TAILLE DE L'IMAGE / BACKGROUND-SIZE
    // REGLAGE

    $wp_customize->add_setting('body_bg_size',array('default'=>'auto','sanitize_callback'=>'esc_attr'));

    // CONTROL

    $wp_customize->add_control('body_bg_size',array(
        'label'=>'Taille de l\'image de fond',
        'section'=>'ma_section',
        'settings'=>'body_bg_size',
        'type'=>'select',
        'choices'=>array(
            'auto'=>'Automatique',
            'contain'=>'Contenu à l\'interieur de son container',
            'cover'=>'Etalement sur toute la largeur et hauteur'
        )));



    // BACKGROUND-ATTACHMENT / SCROLL OU FIXED
    // REGLAGE

    $wp_customize->add_setting('body_bg_attachment',array('default'=>'scroll','sanitize_callback'=>'esc_attr'));

    // CONTROL

    $wp_customize->add_control('bd_bg_attachment',array(
        'label'=>'Scroll ou Fixed',
        'section'=>'ma_section',
        'settings'=>'body_bg_attachment',
        'type'=>'select',
        'choices'=>array(
            'scroll'=>'Défilement',
            'fixed'=>'Fixe'
        )));

    // BACKGROUND-REPEAT /
    //REGLAGE
      $wp_customize->add_setting('body_bg_repeat',array('default'=>'repeat','sanitize_callback'=>'esc_attr'));   

    //CONTROL

     $wp_customize->add_control('body_bg_repeat',array(
        'label'=>'Choisir de répeter ou non le fond du site',
        'section'=>'ma_section',
        'settings'=>'body_bg_repeat',
        'type'=>'select',
        'choices'=>array(
            'repeat'=>'Répéter',
            'no-repeat'=>'Ne pas répéter',
            'repeat-x'=>'Répéter sur l\'horizontal',
            'repeat-y'=>'Répéter sur la verticale'
        )));       

    // TOPBAR

        // creation d'une nouvelle section

        $wp_customize->add_section('section_topbar',array(
            'title'=>'Paramètres de la Topbar',
            'description'=>'Personnalisation de la Top barre',
            'priority'=>140
        ));
        
        // activer ou desactiver la topbar

        // reglage
            $wp_customize->add_setting('active_topbar',array('default'=>'top-bar','sanitize_callback'=>'esc_attr'));


        // controle

        $wp_customize->add_control('active_tb',array(
            'label'=>'Activer ou desactiver la Topbar',
            'section'=>'section_topbar',            
            'settings'=>'active_topbar',
            'type'=>'select',
            'choices'=>array(
                'top-bar'=>'Topbar affichée',
                'hidden'=>'Topbar cachée'
            )));
        

        //Couleur background topbar

            // Reglage

            $wp_customize->add_setting('topbar_background',array(
                'default'=>'#000000',
                'sanitize_callback'=>'sanitize_hex_color',
                'capability'=>'edit_theme_options',
                'type'=>'theme_mod',
                'transport'=>'refresh'
            ));

            // Controle

            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'topbar_bg',array(
                'label'=>'Couleur de fond de la topbar',
                'section'=>'section_topbar',
                'settings'=>'topbar_background'
            )));

        // couleur texte topbar
            // Reglage
             $wp_customize->add_setting('topbar_text',array(
                'default'=>'#ffffff',
                'sanitize_callback'=>'sanitize_hex_color',
                'capability'=>'edit_theme_options',
                'type'=>'theme_mod',
                'transport'=>'refresh'
            ));

            // Controle
                $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'topbar_txt',array(
                'label'=>'Couleur des textes de la topbar',
                'section'=>'section_topbar',
                'settings'=>'topbar_text'
            )));

        // couleur des liens topbar

            // Reglage
             $wp_customize->add_setting('topbar_link',array(
                'default'=>'#e9d7e8 ',
                'sanitize_callback'=>'sanitize_hex_color',
                'capability'=>'edit_theme_options',
                'type'=>'theme_mod',
                'transport'=>'refresh'
            ));

            // Controle
            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'tb_link',array(
                'label'=>'Couleur des liens de la topbar',
                'section'=>'section_topbar',
                'settings'=>'topbar_link'
            )));

        // Numero de telephone : (champ texte)

        //reglage
        $wp_customize->add_setting('phone_number',array('default'=>'+33(0)12 345 678','sanitize_callback'=>'esc_html'));

        // controle
        
        $wp_customize->add_control('phone-nb',array(
            'label'=>'Texte à ajouter dans la topbar',
            'section'=>'section_topbar',
            'settings'=>'phone_number',
            'type'=>'text'
        ));

        // Case à cocher pour afficher le texte

        //reglage

        $wp_customize->add_setting('display_phone_number',array('sanitize_callback'=>'esc_html'));

        // controle

        $wp_customize->add_control('display_phone',array(
            'label'=>'Afficher le texte dans la topbar',
            'section'=>'section_topbar',
            'settings'=>'display_phone_number',
            'type'=>'checkbox'
        ));

     //FIN TOP BAR


     /* ************** HEADER **************** */

     $wp_customize->add_section('section_header',array(
        'title'=>'Paramètres du Header',
        'description'=>' Réglage du header, logo, menu, réseaux sociaux',
        'priority'=>150 ));

     // LOGO
     // Reglage
     $wp_customize->add_setting('logo_site',array('sanitize_callback'=>'esc_attr'));

     // controle

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,'logo_site',array(
        'label'=>'Chargez votre logo',
        'section'=>'section_header',
        'settings'=>'logo_site'
    )));

     // Placement horizontal des éléments avec Flex

     // reglage
    $wp_customize->add_setting('justify_content_header',array('default'=>'space-around','sanitize_callback'=>'esc_attr'));

     // controle
    
     $wp_customize->add_control('justify-header',array(
        'label'=>'Choisir un positionnement horizontal des éléments',
        'section'=>'section_header',
        'settings'=>'justify_content_header',
        'type'=>'select',
        'choices'=>array(
            'flex-start'=> 'Gauche',
            'flex-end'=>'droite',
            'center'=>'au centre',
            'space-around'=>'espaces autour',
            'space-between'=>'espaces entre'
        )
     ));


         // Placement vertical des éléments avec Flex

     // reglage
    $wp_customize->add_setting('align_items_header',array('default'=>'center','sanitize_callback'=>'esc_attr'));

     // controle
    
     $wp_customize->add_control('align_header',array(
        'label'=>'Choisir un positionnement vertical des éléments',
        'section'=>'section_header',
        'settings'=>'align_items_header',
        'type'=>'select',
        'choices'=>array(
            'flex-start'=> 'En haut',
            'flex-end'=>'En bas',
            'center'=>'Au centre',
            'baseline'=>'A la base'
            
        )));

     // Couleur des textes

    // ajout du reglage
    $wp_customize->add_setting('color_text_header',array(
            'default'=>'#000000',
            'sanitize_callback'=>'sanitize_hex_color',
            'capability'=>'edit_theme_options',
            'type'=>'theme_mod',
            'transport'=>'refresh'
        ));

    //Ajout du controle
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'color_txt_header',array(
        'label'=>'Couleur des textes',
        'section' =>'section_header',
        'settings'=>'color_text_header'

    )));

    // Couleur des liens

        // ajout du reglage
    $wp_customize->add_setting('color_link_header',array(
            'default'=>'#d95370 ',
            'sanitize_callback'=>'sanitize_hex_color',
            'capability'=>'edit_theme_options',
            'type'=>'theme_mod',
            'transport'=>'refresh'
        ));

    //Ajout du controle
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'color_lk_header',array(
        'label'=>'Couleur des liens',
        'section' =>'section_header',
        'settings'=>'color_link_header'

    )));
     // IMAGE DE FOND DU HEADER
// BACKGROUND
    // IMAGE
    // reglage => settings
        $wp_customize->add_setting('bg_header',array('sanitize_callback'=>'esc_attr'));

    // controle

        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,'background_header',array(
            'label'=>'Fond du header',
            'section'=>'section_header',
            'settings'=>'bg_header'
        )));

    // Couleur du background

    // ajout du reglage
    $wp_customize->add_setting('color_background_header',array(
            'default'=>'#ffffff',
            'sanitize_callback'=>'sanitize_hex_color',
            'capability'=>'edit_theme_options',
            'type'=>'theme_mod',
            'transport'=>'refresh'
        ));

    //Ajout du controle
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'color_bg_header',array(
        'label'=>'Couleur du background',
        'section' =>'section_header',
        'settings'=>'color_background_header'

    )));


    //  POSITION DE L'IMAGE / BACKGROUND-POSITION
        // REGLAGE

        $wp_customize->add_setting('header_bg_position',array('default'=>'center center','sanitize_callback'=>'esc_attr'));
        //CONTROLE


        // à gauche en haut (left top)
        // a gauche en bas ( left bottom)
        // au centre ( center center)
        // a droite en haut (right top)
        //a droite en bas (right bottom)

        $wp_customize->add_control('header_bg_position',array(
        'label'=>'Position de l\'image de fond',
        'section'=>'section_header',
        'settings'=>'header_bg_position',
        'type'=>'select',
        'choices'=>array(
            'left top'=>'à gauche en haut',
            'left bottom'=>'a gauche en bas',
            'center center'=>'au centre',
            'right top'=>'à droite en haut',
            'right bottom'=>'a droite en bas'
        )));
        

    // TAILLE DE L'IMAGE / BACKGROUND-SIZE
    // REGLAGE

    $wp_customize->add_setting('header_bg_size',array('default'=>'auto','sanitize_callback'=>'esc_attr'));

    // CONTROL

    $wp_customize->add_control('header_bg_size',array(
        'label'=>'Taille de l\'image de fond',
        'section'=>'section_header',
        'settings'=>'header_bg_size',
        'type'=>'select',
        'choices'=>array(
            'auto'=>'Automatique',
            'contain'=>'Contenu à l\'interieur de son container',
            'cover'=>'Etalement sur toute la largeur et hauteur'
        )));



    // BACKGROUND-ATTACHMENT / SCROLL OU FIXED
    // REGLAGE

    $wp_customize->add_setting('header_bg_attachment',array('default'=>'scroll','sanitize_callback'=>'esc_attr'));

    // CONTROL

    $wp_customize->add_control('header_bg_attachment',array(
        'label'=>'Scroll ou Fixed',
        'section'=>'section_header',
        'settings'=>'header_bg_attachment',
        'type'=>'select',
        'choices'=>array(
            'scroll'=>'Défilement',
            'fixed'=>'Fixe'
        )));

    // BACKGROUND-REPEAT /
    //REGLAGE
      $wp_customize->add_setting('header_bg_repeat',array('default'=>'repeat','sanitize_callback'=>'esc_attr'));   

    //CONTROL

     $wp_customize->add_control('header_bg_repeat',array(
        'label'=>'Choisir de répeter ou non le fond du site',
        'section'=>'section_header',
        'settings'=>'header_bg_repeat',
        'type'=>'select',
        'choices'=>array(
            'repeat'=>'Répéter',
            'no-repeat'=>'Ne pas répéter',
            'repeat-x'=>'Répéter sur l\'horizontal',
            'repeat-y'=>'Répéter sur la verticale'
        )));       


     // FIN DU HEADER
      /* ************** FOOTER **************** */

     $wp_customize->add_section('section_footer',array(
        'title'=>'Paramètres du footer',
        'description'=>' Réglage du footer',
        'priority'=>170 ));


     // Placement horizontal des éléments avec Flex

     // reglage
    $wp_customize->add_setting('justify_content_footer',array('default'=>'space-around','sanitize_callback'=>'esc_attr'));

     // controle
    
     $wp_customize->add_control('justify-footer',array(
        'label'=>'Choisir un positionnement horizontal des éléments',
        'section'=>'section_footer',
        'settings'=>'justify_content_footer',
        'type'=>'select',
        'choices'=>array(
            'flex-start'=> 'Gauche',
            'flex-end'=>'droite',
            'center'=>'au centre',
            'space-around'=>'espaces autour',
            'space-between'=>'espaces entre'
        )
     ));


         // Placement vertical des éléments avec Flex

     // reglage
    $wp_customize->add_setting('align_items_footer',array('default'=>'center','sanitize_callback'=>'esc_attr'));

     // controle
    
     $wp_customize->add_control('align_footer',array(
        'label'=>'Choisir un positionnement vertical des éléments',
        'section'=>'section_footer',
        'settings'=>'align_items_footer',
        'type'=>'select',
        'choices'=>array(
            'flex-start'=> 'En haut',
            'flex-end'=>'En bas',
            'center'=>'Au centre',
            'baseline'=>'A la base'
            
        )));

     // Couleur des textes

    // ajout du reglage
    $wp_customize->add_setting('color_text_footer',array(
            'default'=>'#000000',
            'sanitize_callback'=>'sanitize_hex_color',
            'capability'=>'edit_theme_options',
            'type'=>'theme_mod',
            'transport'=>'refresh'
        ));

    //Ajout du controle
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'color_txt_footer',array(
        'label'=>'Couleur des textes',
        'section' =>'section_footer',
        'settings'=>'color_text_footer'

    )));

    // Couleur des liens

        // ajout du reglage
    $wp_customize->add_setting('color_link_footer',array(
            'default'=>'#d95370 ',
            'sanitize_callback'=>'sanitize_hex_color',
            'capability'=>'edit_theme_options',
            'type'=>'theme_mod',
            'transport'=>'refresh'
        ));

    //Ajout du controle
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'color_lk_footer',array(
        'label'=>'Couleur des liens',
        'section' =>'section_footer',
        'settings'=>'color_link_footer'

    )));
     // IMAGE DE FOND DU footer
// BACKGROUND
    // IMAGE
    // reglage => settings
        $wp_customize->add_setting('bg_footer',array('sanitize_callback'=>'esc_attr'));

    // controle

        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,'background_footer',array(
            'label'=>'Fond du footer',
            'section'=>'section_footer',
            'settings'=>'bg_footer'
        )));

    // Couleur du background

    // ajout du reglage
    $wp_customize->add_setting('color_background_footer',array(
            'default'=>'#ffffff',
            'sanitize_callback'=>'sanitize_hex_color',
            'capability'=>'edit_theme_options',
            'type'=>'theme_mod',
            'transport'=>'refresh'
        ));

    //Ajout du controle
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'color_bg_footer',array(
        'label'=>'Couleur du background',
        'section' =>'section_footer',
        'settings'=>'color_background_footer'

    )));


    //  POSITION DE L'IMAGE / BACKGROUND-POSITION
        // REGLAGE

        $wp_customize->add_setting('footer_bg_position',array('default'=>'center center','sanitize_callback'=>'esc_attr'));
        //CONTROLE


        // à gauche en haut (left top)
        // a gauche en bas ( left bottom)
        // au centre ( center center)
        // a droite en haut (right top)
        //a droite en bas (right bottom)

        $wp_customize->add_control('footer_bg_position',array(
        'label'=>'Position de l\'image de fond',
        'section'=>'section_footer',
        'settings'=>'footer_bg_position',
        'type'=>'select',
        'choices'=>array(
            'left top'=>'à gauche en haut',
            'left bottom'=>'a gauche en bas',
            'center center'=>'au centre',
            'right top'=>'à droite en haut',
            'right bottom'=>'a droite en bas',
            'top center'=>'en haut au centre',
            'bottom center'=>'en bas au centre'
        )));
        

    // TAILLE DE L'IMAGE / BACKGROUND-SIZE
    // REGLAGE

    $wp_customize->add_setting('footer_bg_size',array('default'=>'auto','sanitize_callback'=>'esc_attr'));

    // CONTROL

    $wp_customize->add_control('footer_bg_size',array(
        'label'=>'Taille de l\'image de fond',
        'section'=>'section_footer',
        'settings'=>'footer_bg_size',
        'type'=>'select',
        'choices'=>array(
            'auto'=>'Automatique',
            'contain'=>'Contenu à l\'interieur de son container',
            'cover'=>'Etalement sur toute la largeur et hauteur'
        )));



    // BACKGROUND-ATTACHMENT / SCROLL OU FIXED
    // REGLAGE

    $wp_customize->add_setting('footer_bg_attachment',array('default'=>'scroll','sanitize_callback'=>'esc_attr'));

    // CONTROL

    $wp_customize->add_control('footer_bg_attachment',array(
        'label'=>'Scroll ou Fixed',
        'section'=>'section_footer',
        'settings'=>'footer_bg_attachment',
        'type'=>'select',
        'choices'=>array(
            'scroll'=>'Défilement',
            'fixed'=>'Fixe'
        )));

    // BACKGROUND-REPEAT /
    //REGLAGE
      $wp_customize->add_setting('footer_bg_repeat',array('default'=>'repeat','sanitize_callback'=>'esc_attr'));   

    //CONTROL

     $wp_customize->add_control('footer_bg_repeat',array(
        'label'=>'Choisir de répeter ou non le fond du site',
        'section'=>'section_footer',
        'settings'=>'footer_bg_repeat',
        'type'=>'select',
        'choices'=>array(
            'repeat'=>'Répéter',
            'no-repeat'=>'Ne pas répéter',
            'repeat-x'=>'Répéter sur l\'horizontal',
            'repeat-y'=>'Répéter sur la verticale'
        )));       


         // copyright : (champ texte)

        //reglage
        $wp_customize->add_setting('copyright',array('default'=>'Copyright 2023 - Tous droits réservés','sanitize_callback'=>'esc_html'));

        // controle
        
        $wp_customize->add_control('copyright-footer',array(
            'label'=>'Texte à ajouter dans le footer',
            'section'=>'section_footer',
            'settings'=>'copyright',
            'type'=>'text'
        ));

    
     // FIN DU FOOTER
     /* ************** BOTTOM **************** */

     $wp_customize->add_section('section_bottom',array(
        'title'=>'Paramètres du bottom',
        'description'=>' Réglage du bottom',
        'priority'=>160 ));


     // Placement horizontal des éléments avec Flex

     // reglage
    $wp_customize->add_setting('justify_content_bottom',array('default'=>'space-around','sanitize_callback'=>'esc_attr'));

     // controle
    
     $wp_customize->add_control('justify-bottom',array(
        'label'=>'Choisir un positionnement horizontal des éléments',
        'section'=>'section_bottom',
        'settings'=>'justify_content_bottom',
        'type'=>'select',
        'choices'=>array(
            'flex-start'=> 'Gauche',
            'flex-end'=>'droite',
            'center'=>'au centre',
            'space-around'=>'espaces autour',
            'space-between'=>'espaces entre'
        )
     ));

     // Placement vertical des éléments avec Flex

     // reglage
    $wp_customize->add_setting('align_items_bottom',array('default'=>'center','sanitize_callback'=>'esc_attr'));

     // controle
    
     $wp_customize->add_control('align_bottom',array(
        'label'=>'Choisir un positionnement vertical des éléments',
        'section'=>'section_bottom',
        'settings'=>'align_items_bottom',
        'type'=>'select',
        'choices'=>array(
            'flex-start'=> 'En haut',
            'flex-end'=>'En bas',
            'center'=>'Au centre',
            'baseline'=>'A la base'
            
        )));

     // Couleur des textes

    // ajout du reglage
    $wp_customize->add_setting('color_text_bottom',array(
            'default'=>'#000000',
            'sanitize_callback'=>'sanitize_hex_color',
            'capability'=>'edit_theme_options',
            'type'=>'theme_mod',
            'transport'=>'refresh'
        ));

    //Ajout du controle
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'color_txt_bottom',array(
        'label'=>'Couleur des textes',
        'section' =>'section_bottom',
        'settings'=>'color_text_bottom'

    )));

    // Couleur des liens

        // ajout du reglage
    $wp_customize->add_setting('color_link_bottom',array(
            'default'=>'#d95370 ',
            'sanitize_callback'=>'sanitize_hex_color',
            'capability'=>'edit_theme_options',
            'type'=>'theme_mod',
            'transport'=>'refresh'
        ));

    //Ajout du controle
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'color_lk_bottom',array(
        'label'=>'Couleur des liens',
        'section' =>'section_bottom',
        'settings'=>'color_link_bottom'

    )));
     // IMAGE DE FOND DU footer
// BACKGROUND
    // IMAGE
    // reglage => settings
        $wp_customize->add_setting('bg_bottom',array('sanitize_callback'=>'esc_attr'));

    // controle

        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,'background_bottom',array(
            'label'=>'Fond du bottom',
            'section'=>'section_bottom',
            'settings'=>'bg_bottom'
        )));

    // Couleur du background

    // ajout du reglage
    $wp_customize->add_setting('color_background_bottom',array(
            'default'=>'#ffffff',
            'sanitize_callback'=>'sanitize_hex_color',
            'capability'=>'edit_theme_options',
            'type'=>'theme_mod',
            'transport'=>'refresh'
        ));

    //Ajout du controle
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize,'color_bg_bottom',array(
        'label'=>'Couleur du background',
        'section' =>'section_bottom',
        'settings'=>'color_background_bottom'

    )));


    //  POSITION DE L'IMAGE / BACKGROUND-POSITION
        // REGLAGE

        $wp_customize->add_setting('footer_bg_position',array('default'=>'center center','sanitize_callback'=>'esc_attr'));
        //CONTROLE


        // à gauche en haut (left top)
        // a gauche en bas ( left bottom)
        // au centre ( center center)
        // a droite en haut (right top)
        //a droite en bas (right bottom)

        $wp_customize->add_control('bottom_bg_position',array(
        'label'=>'Position de l\'image de fond',
        'section'=>'section_bottom',
        'settings'=>'bottom_bg_position',
        'type'=>'select',
        'choices'=>array(
            'left top'=>'à gauche en haut',
            'left bottom'=>'a gauche en bas',
            'center center'=>'au centre',
            'right top'=>'à droite en haut',
            'right bottom'=>'a droite en bas',
            'top center'=>'en haut au centre',
            'bottom center'=>'en bas au centre'
        )));
        

    // TAILLE DE L'IMAGE / BACKGROUND-SIZE
    // REGLAGE

    $wp_customize->add_setting('bottom_bg_size',array('default'=>'auto','sanitize_callback'=>'esc_attr'));

    // CONTROL

    $wp_customize->add_control('bottom_bg_size',array(
        'label'=>'Taille de l\'image de fond',
        'section'=>'section_bottom',
        'settings'=>'bottom_bg_size',
        'type'=>'select',
        'choices'=>array(
            'auto'=>'Automatique',
            'contain'=>'Contenu à l\'interieur de son container',
            'cover'=>'Etalement sur toute la largeur et hauteur'
        )));



    // BACKGROUND-ATTACHMENT / SCROLL OU FIXED
    // REGLAGE

    $wp_customize->add_setting('bottom_bg_attachment',array('default'=>'scroll','sanitize_callback'=>'esc_attr'));

    // CONTROL

    $wp_customize->add_control('bottom_bg_attachment',array(
        'label'=>'Scroll ou Fixed',
        'section'=>'section_bottom',
        'settings'=>'bottom_bg_attachment',
        'type'=>'select',
        'choices'=>array(
            'scroll'=>'Défilement',
            'fixed'=>'Fixe'
        )));

    // BACKGROUND-REPEAT /
    //REGLAGE
      $wp_customize->add_setting('bottom_bg_repeat',array('default'=>'repeat','sanitize_callback'=>'esc_attr'));   

    //CONTROL

     $wp_customize->add_control('bottom_bg_repeat',array(
        'label'=>'Choisir de répeter ou non le fond du site',
        'section'=>'section_bottom',
        'settings'=>'bottom_bg_repeat',
        'type'=>'select',
        'choices'=>array(
            'repeat'=>'Répéter',
            'no-repeat'=>'Ne pas répéter',
            'repeat-x'=>'Répéter sur l\'horizontal',
            'repeat-y'=>'Répéter sur la verticale'
        )));       

    
     // FIN DU BOTTOM

}

add_action('customize_register','theme_customize_register');



function theme_customize_css(){
    // appliquer les paramètres sur le css
?>
    <style type="text/css">
        a{color:<?php echo esc_attr(get_theme_mod('couleur_liens','#000000')); ?>;}

        /* couleur background*/ 

        body{background-color:<?php echo esc_attr(get_theme_mod('color_background','#ffffff')); ?>;color:<?php echo esc_attr(get_theme_mod('color_text','#000000')); ?>;
             background-image:url(<?php echo esc_attr(get_theme_mod('bg_site','none')); ?>);
             background-position: <?php echo esc_attr(get_theme_mod('body_bg_position','0 0')); ?>;
             background-repeat: <?php echo esc_attr(get_theme_mod('body_bg_repeat','repeat')); ?>;
             background-attachment: <?php echo esc_attr(get_theme_mod('body_bg_attachment','scroll')); ?>;
             background-size:<?php echo esc_attr(get_theme_mod('body_bg_size','auto'));?>;     
            
            }

        #topbar{background-color:<?php echo esc_attr(get_theme_mod('topbar_background','#000000')); ?>;
            color:<?php echo esc_attr(get_theme_mod('topbar_text','#ffffff')); ?>;}

        #topbar a{color:<?php echo esc_attr(get_theme_mod('topbar_link','#e9d7e8')); ?>;}
        
        header{justify-content:<?php echo esc_attr(get_theme_mod('justify_content_header','space-around'));?>;
            align-items:<?php echo esc_attr(get_theme_mod('align_items_header','center')) ?>;
            background-color:<?php echo esc_attr(get_theme_mod('color_background_header','#ffffff')); ?>;
             background-image:url(<?php echo esc_attr(get_theme_mod('bg_header','none')); ?>);
             background-position: <?php echo esc_attr(get_theme_mod('header_bg_position','0 0')); ?>;
             background-repeat: <?php echo esc_attr(get_theme_mod('header_bg_repeat','repeat')); ?>;
             background-attachment: <?php echo esc_attr(get_theme_mod('header_bg_attachment','scroll')); ?>;
             background-size:<?php echo esc_attr(get_theme_mod('header_bg_size','auto'));?>; 
             color:<?php echo esc_attr(get_theme_mod('color_text_header','#000000')); ?>;
        }

        header a{color:<?php echo esc_attr(get_theme_mod('color_link_header','#d95370 '));?>;}

        .logo{background-image:url(<?php echo esc_attr(get_theme_mod('logo_site','none')); ?>);
              background-repeat : no-repeat;
              background-position: center center;
              height :<?php if(get_theme_mod('logo_site')!=='')
              { echo '100px';}
               else{ echo 'auto';} 
              ?>;
              min-width:<?php if(get_theme_mod('logo_site')!=='')
              { echo '200px';}
               else{ echo 'auto';} 
              ?>;

            }
            footer{justify-content:<?php echo esc_attr(get_theme_mod('justify_content_footer','space-around'));?>;
            align-items:<?php echo esc_attr(get_theme_mod('align_items_footer','center')) ?>;
            background-color:<?php echo esc_attr(get_theme_mod('color_background_footer','#ffffff')); ?>;
             background-image:url(<?php echo esc_attr(get_theme_mod('bg_footer','none')); ?>);
             background-position: <?php echo esc_attr(get_theme_mod('footer_bg_position','0 0')); ?>;
             background-repeat: <?php echo esc_attr(get_theme_mod('footer_bg_repeat','repeat')); ?>;
             background-attachment: <?php echo esc_attr(get_theme_mod('footer_bg_attachment','scroll')); ?>;
             background-size:<?php echo esc_attr(get_theme_mod('footer_bg_size','auto'));?>; 
             color:<?php echo esc_attr(get_theme_mod('color_text_footer','#000000')); ?>;
             padding:1em;
        }

       footer a{color:<?php echo esc_attr(get_theme_mod('color_link_footer','#d95370 '));?>;}


       .bottom{justify-content:<?php echo esc_attr(get_theme_mod('justify_content_bottom','space-around'));?>;
            align-items:<?php echo esc_attr(get_theme_mod('align_items_bottom','center')) ?>;
            background-color:<?php echo esc_attr(get_theme_mod('color_background_bottom','#ffffff')); ?>;
             background-image:url(<?php echo esc_attr(get_theme_mod('bg_bottom','none')); ?>);
             background-position: <?php echo esc_attr(get_theme_mod('bottom_bg_position','0 0')); ?>;
             background-repeat: <?php echo esc_attr(get_theme_mod('bottom_bg_repeat','repeat')); ?>;
             background-attachment: <?php echo esc_attr(get_theme_mod('bottom_bg_attachment','scroll')); ?>;
             background-size:<?php echo esc_attr(get_theme_mod('bottom_bg_size','auto'));?>; 
             color:<?php echo esc_attr(get_theme_mod('color_text_bottom','#000000')); ?>;
             padding:1em;
        }

       .bottom a{color:<?php echo esc_attr(get_theme_mod('color_link_bottom','#d95370 '));?>;}
    </style>

<?php     
}

add_action('wp_head','theme_customize_css');