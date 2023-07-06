<?php 
// Création d'un widget
function mon_register_widget() {

register_widget( 'titre_perso' );

}

add_action( 'widgets_init', 'mon_register_widget' );

////////////////////////////////////
class titre_perso extends WP_Widget {

function __construct() {

parent::__construct(

// identifiant du widget

'titre-perso',

// nom du widget

__('Shortcode Titre', ' deltatheme'),

// description du widget

array( 'description' => __( 'Widget qui permet d\integrer un shortcode pour personnaliser un titre', 'deltatheme' ), )

);

}

public function widget( $args, $instance ) {

$title = apply_filters( 'widget_title', $instance['title'] );
$contenu = apply_filters('widget_desc', $instance['contenu']);
echo $args['before_widget'];

//si un titre existe

if ( ! empty( $title ) )

echo $args['before_title'] . $title . $args['after_title'];


//si un contenu existe

if ( ! empty( $contenu ) )

echo "<p>" . $contenu . "</p>";

//sortie du widget

echo __( 'Ceci est un widget personnalisé!', 'deltatheme' );

echo $args['after_widget'];

}

public function form( $instance ) {

if ( isset( $instance[ 'title' ] ) )

$title = $instance[ 'title' ];



else

$contenu = __( 'Titre perso', 'deltatheme' );

if ( isset( $instance[ 'contenu' ] ) )

$contenu = $instance[ 'contenu' ];



else

$contenu = __( 'Mettez ici le texte de votre choix', 'deltatheme' );


?>

<p>

<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Titre:' ); ?></label>

<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />

<label for="<?php echo $this->get_field_id( 'contenu' ); ?>"><?php _e( 'Contenu:' ); ?></label>

<textarea id="<?php echo $this->get_field_id( 'contenu' ); ?>" name="<?php echo $this->get_field_name( 'contenu' ); ?>" value="<?php echo esc_attr( $contenu ); ?>"></textarea>

</p>

<?php

}

public function update( $new_instance, $old_instance ) {

$instance = array();

$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
$instance['contenu'] = ( ! empty( $new_instance['contenu'] ) ) ? strip_tags( $new_instance['contenu'] ) : '';
return $instance;

}

}?>