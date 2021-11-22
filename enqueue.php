<?php 

function car_enqueue_styles(){
    wp_enqueue_style('bootstrap-style', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap-grid.min.css');
    wp_enqueue_style('main-style', plugin_dir_url( __FILE__ ) . 'assets/styles.css');

    wp_register_script('car-script', plugin_dir_url( __FILE__ ) . 'assets/script.js', array('jquery'), '1.0', true);
	wp_localize_script(
		'car-script',
		'car_obj',
		array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'token' => wp_create_nonce('car-token')
		)
	);
	wp_enqueue_script('car-script');
}