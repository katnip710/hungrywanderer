<?php
/**
 * Register custom post types called "testimonial" and "event".
 *
 * @see get_post_type_labels() for label keys.
 */
function travel_theme_init_post_types() {
    $labels = array(
        'name'                  => esc_html_x( 'Testimonials', 'Post type general name', 'travel_theme' ),
        'singular_name'         => esc_html_x( 'Testimonial', 'Post type singular name', 'travel_theme' ),
        'menu_name'             => esc_html_x( 'Testimonials', 'Admin Menu text', 'travel_theme' ),
        'name_admin_bar'        => esc_html_x( 'Testimonial', 'Add New on Toolbar', 'travel_theme' ),
        'add_new'               => esc_html__( 'Add New', 'travel_theme' ),
        'add_new_item'          => esc_html__( 'Add New Testimonial', 'travel_theme' ),
        'new_item'              => esc_html__( 'New Testimonial', 'travel_theme' ),
        'edit_item'             => esc_html__( 'Edit Testimonial', 'travel_theme' ),
        'view_item'             => esc_html__( 'View Testimonial', 'travel_theme' ),
        'all_items'             => esc_html__( 'All Testimonials', 'travel_theme' ),
        'search_items'          => esc_html__( 'Search Testimonials', 'travel_theme' ),
        'parent_item_colon'     => esc_html__( 'Parent Testimonials:', 'travel_theme' ),
        'not_found'             => esc_html__( 'No Testimonials found.', 'travel_theme' ),
        'not_found_in_trash'    => esc_html__( 'No Testimonials found in Trash.', 'travel_theme' ),
        'archives'              => esc_html_x( 'Testimonial archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'travel_theme' ),
        'insert_into_item'      => esc_html_x( 'Insert into Testimonial', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'travel_theme' ),
        'uploaded_to_this_item' => esc_html_x( 'Uploaded to this Testimonial', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'travel_theme' ),
        'filter_items_list'     => esc_html_x( 'Filter Testimonials list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'travel_theme' ),
        'items_list_navigation' => esc_html_x( 'Testimonials list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'travel_theme' ),
        'items_list'            => esc_html_x( 'Testimonials list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'travel_theme' ),
    );
 
    /**
     * Testimonial
     */
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'testimonials' ), //slugs should be plural
        'capability_type'    => 'post',  //posts should be singular
        'has_archive'        => true,    
        'hierarchical'       => false,   //no children, just parent
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-format-status',
        'show_in_rest'       => true,  //to use guttenberg editor
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
        'show_admin_column'  => true,
    );
 
    register_post_type( 'travel_theme_book', $args );

    /**
     * Event
     */
    $labels = array(
        'name'                  => esc_html_x( 'Events', 'Post type general name', 'travel_theme' ),
        'singular_name'         => esc_html_x( 'Event', 'Post type singular name', 'travel_theme' ),
        'menu_name'             => esc_html_x( 'Events', 'Admin Menu text', 'travel_theme' ),
        'name_admin_bar'        => esc_html_x( 'Event', 'Add New on Toolbar', 'travel_theme' ),
        'add_new'               => esc_html__( 'Add New', 'travel_theme' ),
        'add_new_item'          => esc_html__( 'Add New Event', 'travel_theme' ),
        'new_item'              => esc_html__( 'New Event', 'travel_theme' ),
        'edit_item'             => esc_html__( 'Edit Event', 'travel_theme' ),
        'view_item'             => esc_html__( 'View Event', 'travel_theme' ),
        'all_items'             => esc_html__( 'All Events', 'travel_theme' ),
        'search_items'          => esc_html__( 'Search Events', 'travel_theme' ),
        'parent_item_colon'     => esc_html__( 'Parent Events:', 'travel_theme' ),
        'not_found'             => esc_html__( 'No Events found.', 'travel_theme' ),
        'not_found_in_trash'    => esc_html__( 'No Events found in Trash.', 'travel_theme' ),
        'archives'              => esc_html_x( 'Event archives', 'travel_theme' ),
        'insert_into_item'      => esc_html_x( 'Insert into Event', 'travel_theme' ),
        'uploaded_to_this_item' => esc_html_x( 'Uploaded to this Event', 'travel_theme' ),
        'filter_items_list'     => esc_html_x( 'Filter Events list',  'travel_theme' ),
        'items_list_navigation' => esc_html_x( 'Events list navigation', 'travel_theme' ),
        'items_list'            => esc_html_x( 'Events list', 'travel_theme' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'events' ), //slugs should be plural
        'capability_type'    => 'post',  //posts should be singular
        'has_archive'        => false,    
        'hierarchical'       => false,   //no children, just parent
        'menu_position'      => null,
        'menu_icon'          => 'dashicons-calendar-alt',
        'show_in_rest'       => true,  //to use guttenberg editor
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
        'show_admin_column'  => true,
    );

    register_post_type( 'travel_theme_events', $args );
}
 
add_action( 'init', 'travel_theme_init_post_types' );