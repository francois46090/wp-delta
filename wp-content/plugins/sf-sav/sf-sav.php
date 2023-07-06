<?php
/**
 * Plugin Name: SAV Amélioré
 * Plugin URI: https://formation31.fr
 * Description: Un plugin pour activer des flèche de couleurs différentes
 * Author: Stéphanie François
 * Version: 1.0
 * Author URI: https://formation31.fr
 */

// Fonctionnalités 

// declaration du style 
//__FILE__ : contient le chemin vers le plugin d'ou le style est chargé

function add_style_plugin_sav(){
    // plugins_url : monsite/wp-content/plugins/

    wp_enqueue_style('style-sav',plugins_url('sf-sav/style.css','__FILE__'));
}

add_action('wp_head','add_style_plugin_sav');

// BLOCS SERVICES SHORTCODE

function sf_services($atts,$content=null){
    extract(shortcode_atts(array(
        'bg_services'=>'livraison-rose',
        'icons_services'=>'livraison'
    ),$atts,'sfServices'));

    if(empty($content)){
        $content = 'Livraison gratuite';
    }

    $codehtml="<div class='d-flex justify-content-around sf-services $bg_services'>
    <span class='$icons_services'></span>
    <h4>$content</h4></div>";
  

    return $codehtml;
}

add_shortcode('sfServices','sf_services');

// Déclaration de Woocommerce et activation des modeles de pages
function mytheme_add_woocommerce_support(){
    add_theme_support('woocommerce');
}

add_action('after_setup_theme','mytheme_add_woocommerce_support');