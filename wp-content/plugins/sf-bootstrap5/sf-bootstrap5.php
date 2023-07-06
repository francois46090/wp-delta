<?php
/**
 * Plugin Name: Bootstrap 5
 * Plugin URI: https://formation31.fr
 * Description: Un plugin pour activer le css, les icones et ke js de Bootstrap
 * Author: Stéphanie François
 * Version: 1.0
 * Author URI: https://formation31.fr
 */

// Fonctionnalités 
// déclarer les liens vers le cdn de bootstrap

function add_bootstrap5(){

    wp_enqueue_style('bootstrap-5.3','https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css');
    wp_enqueue_style('bootstrap-icons','https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css');    
    // Scripts
    wp_enqueue_script('bootstrap-js',"https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js");

}

add_action('wp_head','add_bootstrap5');


?>