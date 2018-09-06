<?php
/*
Plugin Name: Site Plugin for hujjat.org for salaat times
Description: Site specific code for hujjat salaat times
*/
/* Start Adding Functions Below this Line */
// Register and load the widget
function salaat_load_widget() {
    register_widget( 'salaat_widget' );
}
add_action( 'widgets_init', 'salaat_load_widget' );
 
// Creating the widget 
class salaat_widget extends WP_Widget {
 
    function __construct() {
        parent::__construct(
        
        // Base ID of your widget
        'salaat_widget', 
        
        // Widget name will appear in UI
        __('Salaat times Widget', 'salaat_widget_domain'), 
        
        // Widget description
        array( 'description' => __( 'Salaat times widget', 'salaat_widget_domain' ), ) 
        );
    }
 
    // Creating widget front-end
 
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if ( ! empty( $title ) )
        echo $args['before_title'] . $title . $args['after_title'];
     
        $year = date("Y");
        $month = date("m");
        $day = date("d");
        $response = file_get_contents('https://api.poc.hujjat.org/salaat/city/london/year/' . $year . '/month/' . $month . '/day/' .$day);
        $response = json_decode($response);
        ?>
<ul>Imsaak: <?php echo $response->imsaak; ?></ul>
<ul>Fajr: <?php echo $response->fajr; ?></ul>
<ul>Sunrise: <?php echo $response->sunrise; ?></ul>
<ul>Zohr: <?php echo $response->zohr; ?></ul>
<ul>Sunset: <?php echo $response->sunset; ?></ul>
<ul>Maghrib: <?php echo $response->maghrib; ?></ul>
<?php
        echo $args['after_widget'];
    }
         
    // Widget Backend 
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'Namaaz Times', 'salaat_widget_domain' );
        }
        // Widget admin form
        ?>
        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <?php 
    }
     
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
} // Class wpb_widget ends here
  
/* Stop Adding Functions Below this Line */
?>