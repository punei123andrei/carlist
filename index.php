<?php 
/*
 * Plugin Name: Carlist
 * Description: This plugin creates a shortcode for displaying car post types. Use [carlist] on a page to see it in action!
 * Version: 1.0
 * Author: Zitec
 * Text Domain: carlist
 */

if( !function_exists( 'add_action' ) ){
    exit;
}

// includes
include('init-car.php');
include('add-cars.php');
include('enqueue.php');

// actions
add_action('wp_enqueue_scripts', 'car_enqueue_styles');
add_action('init', 'create_car_post_type');
register_activation_hook(__FILE__, 'add_cars');

// ajax function
include('get-cars.php');
add_action('wp_ajax_get_cars', 'get_cars');
add_action('wp_ajax_nopriv_get_cars', 'get_cars');

// shortcode function
function display_carlist_func($atts){
    $atts = shortcode_atts([
        'fuel' => '',
        'brand' => '',
        'color' => '',
        'showfilters' => 0
    ], $atts);

    $content;

    if($atts['showfilters'] == 1):
            $filter = file_get_contents('templates/filter-template.php', true);    
            $args = array(
                'post_type' => 'car',
                'posts_per_page' => -1
              );
              $cars = get_posts($args);
              
              foreach($cars as $car){
                $fuel_meta[] = get_post_meta($car->ID, 'fuel', true);
                $brand_meta[] = get_post_meta($car->ID, 'brand', true);
                $color_meta[] = get_post_meta($car->ID, 'color', true);
              }
              
              $fuel_unique = array_unique($fuel_meta);
              $brand_unique = array_unique($brand_meta);
              $color_unique = array_unique($color_meta);
              
             
              foreach($fuel_unique as $meta){ 
              $fuelopts .= '<option value="'. $meta . '">'. ucfirst($meta) . '</option>';
               } 
               foreach($brand_unique as $meta){ 
                  $brandopts .= '<option value="'. $meta . '">'. ucfirst($meta) . '</option>';
                   } 
                   foreach($color_unique as $meta){ 
                      $coloropts .= '<option value="'. $meta . '">'. ucfirst($meta) . '</option>';
                       } 
          
               $filter = str_replace( 'Fuel_options', $fuelopts,  $filter);
               $filter = str_replace( 'Brand_options', $brandopts,  $filter);
               $filter = str_replace( 'Color_options', $coloropts,  $filter);
        $content .= $filter;    
                    endif;

    $meta_query = array('relation' => 'AND');

    if(isset($atts['fuel']) AND !empty($atts['fuel'])) {
            $meta_query[] = array(
                'key' => 'fuel', 
                'value' => $atts['fuel'],
                'compare' => 'LIKE'
            );
        }

    if(isset($atts['brand']) AND !empty($atts['brand'])) {
        $meta_query[] = array(
                'key' => 'brand', 
                'value' => $atts['brand'],
                'compare' => 'LIKE'
            );
    }

    if(isset($atts['color']) AND !empty($atts['color'])) {
            $meta_query[] = array(
                'key' => 'color', 
                'value' => $atts['color'],
                'compare' => 'LIKE'
            );
    }

    $args = array(
        'post_type' => 'car',
        'posts_per_page' => -1,
        'meta_query' => $meta_query
        );
    $loop = new WP_Query( $args );
    if ( $loop->have_posts() ) {
        $carItem = file_get_contents('templates/car-template.php', true);
        $content .= '<div class="container car-results">';
        while ( $loop->have_posts() ) : $loop->the_post();
         $item = str_replace( 'TITLE', get_the_title(),  $carItem);
         $item = str_replace( 'FUEL_FIELD', ucfirst(get_post_meta(get_the_ID(), 'fuel', true)),  $item);
         $item = str_replace( 'BRAND_FIELD', ucfirst(get_post_meta(get_the_ID(), 'brand', true)),  $item);
         $item = str_replace( 'COLOR_FIELD', ucfirst(get_post_meta(get_the_ID(), 'color', true)),  $item);
         $content .= $item;
        endwhile;
        $content .= '</div>';
    } else {
        echo __( 'No cars found' );
    }
    wp_reset_postdata();

    return $content;
 }

 add_shortcode('carlist', 'display_carlist_func');



//  Adding metaboxes

 function wporg_add_custom_box() {
    $screens = [ 'car', 'wporg_cpt' ];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'wporg_box_id',                
            'Car fields',      
            'wporg_custom_box_html',  
            $screen                            
        );
    }
}
add_action( 'add_meta_boxes', 'wporg_add_custom_box' );

function wporg_custom_box_html( $post ) {

    $fuel_type = get_post_meta($post->ID, 'fuel', true);
    $brand_type = get_post_meta($post->ID, 'brand', true);
    $color_type = get_post_meta($post->ID, 'color', true);
    ?>
    <label for="fuel">Select fuel</label>
    <select name="fuel" id="fuel" class="postbox">
        <option value="petrol" <?php echo $fuel_type == 'petrol' ? 'selected' : ''; ?>>Petrol</option>
        <option value="diesel" <?php echo $fuel_type == 'diesel' ? 'selected' : ''; ?>>Diesel</option>
        <option value="hybrid" <?php echo $fuel_type == 'hybrid' ? 'selected' : ''; ?>>Hybrid</option>
        <option value="electric" <?php echo $fuel_type == 'electric' ? 'selected' : ''; ?>>Electric</option>
    </select><br>
    <label for="brand">Select brand</label>
    <select name="brand" id="brand" class="postbox">
        <option value="opel" <?php echo $brand_type == 'opel' ? 'selected' : ''; ?>>Opel</option>
        <option value="bmw" <?php echo $brand_type == 'bmw' ? 'selected' : ''; ?>>BMW</option>
        <option value="vw" <?php echo $brand_type == 'vw' ? 'selected' : ''; ?>>Volkswagen</option>
        <option value="dacia" <?php echo $brand_type == 'dacia' ? 'selected' : ''; ?>>Dacia</option>
        <option value="lamborghini" <?php echo $brand_type == 'lamborghini' ? 'selected' : ''; ?>>Lamborghini</option>
        <option value="fiat" <?php echo $brand_type == 'fiat' ? 'selected' : ''; ?>>Fiat</option>
    </select><br>
    <label for="color">Select color</label>
    <select name="color" id="color" class="postbox">
        <option value="green" <?php echo $color_type == 'green' ? 'selected' : ''; ?>>Green</option>
        <option value="cameleon" <?php echo $color_type == 'cameleon' ? 'selected' : ''; ?>>Cameleon</option>
        <option value="red" <?php echo $color_type == 'red' ? 'selected' : ''; ?>>Red</option>
        <option value="yellow" <?php echo $color_type == 'yellow' ? 'selected' : ''; ?>>Yellow</option>
    </select>
    <?php
}



function save_car(){
    global $post; 
        if( isset($_POST) ) : 
             $fuel_meta = esc_attr( $_POST['fuel'] ); 
             $brand_meta = esc_attr( $_POST['brand'] );
             $color_meta = esc_attr( $_POST['color'] );
             // Update post meta
             update_post_meta($post->ID, 'fuel', $fuel_meta); 
             update_post_meta($post->ID, 'brand', $brand_meta);
             update_post_meta($post->ID, 'color', $color_meta);
        endif; 
}
add_action( 'save_post', 'save_car' );

















