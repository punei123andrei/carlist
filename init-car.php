<?php


function create_car_post_type(){
    $labels = array(
        'name'                  => _x( 'Car', 'Post type general name', 'carlist' ),
        'singular_name'         => _x( 'car', 'Post type singular name', 'carlist' ),
        'menu_name'             => _x( 'Cars', 'Admin Menu text', 'carlist' ),
        'name_admin_bar'        => _x( 'car', 'Add New on Toolbar', 'carlist' ),
        'add_new'               => __( 'Add New', 'carlist' ),
        'add_new_item'          => __( 'Add New car', 'carlist' ),
        'new_item'              => __( 'New car', 'carlist' ),
        'edit_item'             => __( 'Edit car', 'carlist' ),
        'view_item'             => __( 'View car', 'carlist' ),
        'all_items'             => __( 'All cars', 'carlist' ),
        'search_items'          => __( 'Search car', 'carlist' ),
        'parent_item_colon'     => __( 'Parent car:', 'carlist' ),
        'not_found'             => __( 'No car found.', 'carlist' ),
        'not_found_in_trash'    => __( 'No car found in Trash.', 'carlist' ),
        'featured_image'        => _x( 'car Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'carlist' ),
        'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'carlist' ),
        'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'carlist' ),
        'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'carlist' ),
        'archives'              => _x( 'car archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'carlist' ),
        'insert_into_item'      => _x( 'Insert into car', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'carlist' ),
        'uploaded_to_this_item' => _x( 'Uploaded to this car', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'carlist' ),
        'filter_items_list'     => _x( 'Filter cars list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'carlist' ),
        'items_list_navigation' => _x( 'car list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'carlist' ),
        'items_list'            => _x( 'car list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'carlist' ),
    );
 
    $args                       =   array(
        'labels'                =>  $labels,
        'description'           =>  'A custom post type for car',
        'menu_icon'             => 'dashicons-car',
        'public'                =>  true,
        'publicly_queryable'    =>  true,
        'show_ui'               =>  true,
        'show_in_menu'          =>  true,
        'query_var'             =>  true,
        'rewrite'               =>  array( 'slug' => 'car' ),
        'capability_type'       =>  'post',
        'has_archive'           =>  true,
        'hierarchical'          =>  false,
        'menu_position'         =>  1,
        'supports'              =>  [ 'title' ],
        'taxonomies'            =>  [ 'category', 'post_tag' ],
        'show_in_rest'          =>  true
    );
 
    register_post_type( 'car', $args );
}
