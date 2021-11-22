<?php 

function add_cars(){
    $cars = ['Fiat P', 'Dacia Buster', 'Dacia Sandero', 'Ferrari Pjen 500', 'Lamborghini G', 'BMW I5', 'Dacia Logan', 'VW Jeta', 'BMW e30', 'Opel Astra'];
   
    foreach($cars as $car){
        $new_post = array(
            'post_type' => 'car',
            'post_title' => $car,
            'post_status' => 'publish'
          );
  
      $post_id = wp_insert_post($new_post);


      $fuel = array('petrol', 'diesel', 'hybrid', 'electric');
    //   $brands = array('fiat', 'dacia', 'ferrari', 'BMW', 'lamborghini', 'volkswagen', 'opel');
      $color = array('red', 'green', 'blue', 'yellow', 'cameleon');

      $match_word = strtolower(strtok($car, " "));
            
      add_post_meta($post_id, 'brand', $match_word);
      add_post_meta($post_id, 'fuel', $fuel[rand(0, 3)]);
      add_post_meta($post_id, 'color', $color[rand(0, 4)]);


    }
}