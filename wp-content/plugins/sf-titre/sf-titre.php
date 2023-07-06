<?php
/**
 * Plugin Name: Titre amélioré
 * Plugin URI: https://formation31.fr
 * Description: Un plugin pour activer des titres sympas
 * Author: Stéphanie François
 * Version: 1.0
 * Author URI: https://formation31.fr
 */

// Fonctionnalités 

// declaration du style 
//__FILE__ : contient le chemin vers le plugin d'ou le style est chargé

function add_style_plugin(){

    wp_enqueue_style('style-titre',plugins_url('sf-titre/style.css','__FILE__'));
}

add_action('wp_head','add_style_plugin');





// ajouter un titre rose,rouge ou noir

function sf_title($atts,$content=null){
// decrire les fonctionnalités de ce shortcode

    extract(shortcode_atts(array(
        'couleur'=>'rose',
        'position'=>'centre'
    ),$atts,'sfTitle'));

// prevoir toujours le cas ou il n'y ait rien !

    if(empty($content)){
        $content='Titre';
    }

// creation d'une variable pour stocker l'affichage des données
$codehtml ="<div><h3 class='sf-title $couleur $position'>$content</h3></div>";
// retourner le résultat
return $codehtml;
}


// ajouter le shortcode et l'initialiser
add_shortcode('sfTitle','sf_title');

?>