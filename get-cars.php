<?php

function get_cars(){
    if (!wp_verify_nonce($_POST['token'], 'car-token')) {
		die('Not a valid request');
	}

    if(isset($_REQUEST)){

        header("Content-Type: application/json"); 
        $meta_query = array('relation' => 'AND');

        if(isset($_REQUEST['fuel']) AND !empty($_REQUEST['fuel'])) {
                $meta_query[] = array(
                    'key' => 'fuel', 
                    'value' => $_REQUEST['fuel'],
                    'compare' => 'LIKE'
                );
            }
    
        if(isset($_REQUEST['brand']) AND !empty($_REQUEST['brand'])) {
            $meta_query[] = array(
                    'key' => 'brand', 
                    'value' => $_REQUEST['brand'],
                    'compare' => 'LIKE'
                );
        }
    
        if(isset($_REQUEST['color']) AND !empty($_REQUEST['color'])) {
                $meta_query[] = array(
                    'key' => 'color', 
                    'value' => $_REQUEST['color'],
                    'compare' => '='
                );
        }

        $result = array();
    
        $args = array(
            'post_type' => 'car',
            'posts_per_page' => -1,
            'meta_query' => $meta_query
            );
        $loop = new WP_Query( $args );
        if ( $loop->have_posts() ) {
            $carItem = file_get_contents('templates/car-template.php', true);
            while ( $loop->have_posts() ) : $loop->the_post();

            $result[] = array(
                "title" => get_the_title(),
                "fuel" => get_post_meta(get_the_ID(), 'fuel', true),
                "brand" => get_post_meta(get_the_ID(), 'brand', true),
                "color" => get_post_meta(get_the_ID(), 'color', true)
            );

           
             
            endwhile;
        } wp_reset_postdata();
       

        wp_send_json($result);

    }
}