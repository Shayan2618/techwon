<?php



add_action( 'init', 'register_acens_Projects' );
function register_acens_Projects() {
    
$labels = array( 
'name' => __( 'Projects', 'acens' ),
'singular_name' => __( 'Projects', 'acens' ),
'add_new' => __( 'Add New Projects', 'acens' ),
'add_new_item' => __( 'Add New Projects', 'acens' ),
'edit_item' => __( 'Edit Projects', 'acens' ),
'new_item' => __( 'New Projects', 'acens' ),
'view_item' => __( 'View Projects', 'acens' ),
'search_items' => __( 'Search Projects', 'acens' ),
'not_found' => __( 'No Projects found', 'acens' ),
'not_found_in_trash' => __( 'No Projects found in Trash', 'acens' ),
'parent_item_colon' => __( 'Parent Projects:', 'acens' ),
'menu_name' => __( 'Projects', 'acens' ),
);

$args = array( 
'labels' => $labels,
'hierarchical' => true,
'description' => 'List Projects',
'supports' => array( 'title', 'editor', 'thumbnail', 'comments'),
'taxonomies' => array( 'Projects', 'type1' ),
'public' => true,
'show_ui' => true,
'show_in_menu' => true,
'menu_position' => 5,
'menu_icon' => 'dashicons-products', 
'show_in_nav_menus' => true,
'publicly_queryable' => true,
'exclude_from_search' => false,
'has_archive' => true,
'query_var' => true,
'can_export' => true,
'rewrite' => true,
'capability_type' => 'post'
);

register_post_type( 'Projects', $args );
}
add_action( 'init', 'create_Type1_hierarchical_taxonomy', 0 );

//create a custom taxonomy name it Skillss for your posts

function create_Type1_hierarchical_taxonomy() {

// Add new taxonomy, make it hierarchical like Skills
//first do the translations part for GUI

$labels = array(
'name' => __( 'Type1', 'acens' ),
'singular_name' => __( 'Type1', 'acens' ),
'search_items' =>  __( 'Search Type1','acens' ),
'all_items' => __( 'All Type1','acens' ),
    'parent_item' => __( 'Parent Type1','acens' ),
    'parent_item_colon' => __( 'Parent Type1:','acens' ),
    'edit_item' => __( 'Edit Type1','acens' ), 
    'update_item' => __( 'Update Type1','acens' ),
    'add_new_item' => __( 'Add New Type1','acens' ),
    'new_item_name' => __( 'New Type1 Name','acens' ),
    'menu_name' => __( 'Type1','acens' ),
  );     

// Now register the taxonomy

  register_taxonomy('type1',array('Projects'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'type1' ),
  ));

}


add_action( 'init', 'register_acens_Services' );
function register_acens_Services() {
    
$labels = array( 
'name' => __( 'Services', 'acens' ),
'singular_name' => __( 'Services', 'acens' ),
'add_new' => __( 'Add New Services', 'acens' ),
'add_new_item' => __( 'Add New Services', 'acens' ),
'edit_item' => __( 'Edit Services', 'acens' ),
'new_item' => __( 'New Services', 'acens' ),
'view_item' => __( 'View Services', 'acens' ),
'search_items' => __( 'Search Services', 'acens' ),
'not_found' => __( 'No Services found', 'acens' ),
'not_found_in_trash' => __( 'No Services found in Trash', 'acens' ),
'parent_item_colon' => __( 'Parent Services:', 'acens' ),
'menu_name' => __( 'Services', 'acens' ),
);

$args = array( 
'labels' => $labels,
'hierarchical' => true,
'description' => 'List Services',
'supports' => array( 'title', 'editor', 'thumbnail', 'comments'),
'taxonomies' => array( 'Services', 'type2' ),
'public' => true,
'show_ui' => true,
'show_in_menu' => true,
'menu_position' => 5,
'menu_icon' => 'dashicons-portfolio', 
'show_in_nav_menus' => true,
'publicly_queryable' => true,
'exclude_from_search' => false,
'has_archive' => true,
'query_var' => true,
'can_export' => true,
'rewrite' => true,
'capability_type' => 'post'
);

register_post_type( 'Services', $args );
}
add_action( 'init', 'create_Type2_hierarchical_taxonomy', 0 );

//create a custom taxonomy name it Skillss for your posts

function create_Type2_hierarchical_taxonomy() {

// Add new taxonomy, make it hierarchical like Skills
//first do the translations part for GUI

$labels = array(
'name' => __( 'Type2', 'acens' ),
'singular_name' => __( 'Type2', 'acens' ),
'search_items' =>  __( 'Search Type2','acens' ),
'all_items' => __( 'All Type2','acens' ),
    'parent_item' => __( 'Parent Type2','acens' ),
    'parent_item_colon' => __( 'Parent Type2:','acens' ),
    'edit_item' => __( 'Edit Type2','acens' ), 
    'update_item' => __( 'Update Type2','acens' ),
    'add_new_item' => __( 'Add New Type2','acens' ),
    'new_item_name' => __( 'New Type2 Name','acens' ),
    'menu_name' => __( 'Type2','acens' ),
  );     

// Now register the taxonomy

  register_taxonomy('Type2',array('Services'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'type2' ),
  ));

}


add_action( 'init', 'register_acens_Team' );
function register_acens_Team() {
    
$labels = array( 
'name' => __( 'Team', 'acens' ),
'singular_name' => __( 'Team', 'acens' ),
'add_new' => __( 'Add New Team', 'acens' ),
'add_new_item' => __( 'Add New Team', 'acens' ),
'edit_item' => __( 'Edit Team', 'acens' ),
'new_item' => __( 'New Team', 'acens' ),
'view_item' => __( 'View Team', 'acens' ),
'search_items' => __( 'Search Team', 'acens' ),
'not_found' => __( 'No Team found', 'acens' ),
'not_found_in_trash' => __( 'No Team found in Trash', 'acens' ),
'parent_item_colon' => __( 'Parent Team:', 'acens' ),
'menu_name' => __( 'Team', 'acens' ),
);

$args = array( 
'labels' => $labels,
'hierarchical' => true,
'description' => 'List Team',
'supports' => array( 'title', 'editor', 'thumbnail', 'comments'),
'taxonomies' => array( 'Team', 'type3' ),
'public' => true,
'show_ui' => true,
'show_in_menu' => true,
'menu_position' => 5,
'menu_icon' => 'dashicons-products', 
'show_in_nav_menus' => true,
'publicly_queryable' => true,
'exclude_from_search' => false,
'has_archive' => true,
'query_var' => true,
'can_export' => true,
'rewrite' => true,
'capability_type' => 'post'
);

register_post_type( 'Team', $args );
}
add_action( 'init', 'create_type3_hierarchical_taxonomy', 0 );

//create a custom taxonomy name it Skillss for your posts

function create_type3_hierarchical_taxonomy() {

// Add new taxonomy, make it hierarchical like Skills
//first do the translations part for GUI

$labels = array(
'name' => __( 'Type3', 'acens' ),
'singular_name' => __( 'Type3', 'acens' ),
'search_items' =>  __( 'Search Type3','acens' ),
'all_items' => __( 'All Type3','acens' ),
    'parent_item' => __( 'Parent Type3','acens' ),
    'parent_item_colon' => __( 'Parent Type3:','acens' ),
    'edit_item' => __( 'Edit Type3','acens' ), 
    'update_item' => __( 'Update Type3','acens' ),
    'add_new_item' => __( 'Add New Type3','acens' ),
    'new_item_name' => __( 'New Type3 Name','acens' ),
    'menu_name' => __( 'Type3','acens' ),
  );     

// Now register the taxonomy

  register_taxonomy('type3',array('Team'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'type3' ),
  ));

}






add_action( 'init', 'register_acens_Event' );
function register_acens_Event() {
    
$labels = array( 
'name' => __( 'Event', 'acens' ),
'singular_name' => __( 'Event', 'acens' ),
'add_new' => __( 'Add New Event', 'acens' ),
'add_new_item' => __( 'Add New Event', 'acens' ),
'edit_item' => __( 'Edit Event', 'acens' ),
'new_item' => __( 'New Event', 'acens' ),
'view_item' => __( 'View Event', 'acens' ),
'search_items' => __( 'Search Event', 'acens' ),
'not_found' => __( 'No Event found', 'acens' ),
'not_found_in_trash' => __( 'No Event found in Trash', 'acens' ),
'parent_item_colon' => __( 'Parent Event:', 'acens' ),
'menu_name' => __( 'Event', 'acens' ),
);

$args = array( 
'labels' => $labels,
'hierarchical' => true,
'description' => 'List Event',
'supports' => array( 'title', 'editor', 'thumbnail', 'comments'),
'taxonomies' => array( 'Event', 'Type4' ),
'public' => true,
'show_ui' => true,
'show_in_menu' => true,
'menu_position' => 5,
'menu_icon' => 'dashicons-text-page', 
'show_in_nav_menus' => true,
'publicly_queryable' => true,
'exclude_from_search' => false,
'has_archive' => true,
'query_var' => true,
'can_export' => true,
'rewrite' => true,
'capability_type' => 'post'
);

register_post_type( 'Event', $args );
}
add_action( 'init', 'create_Type4_hierarchical_taxonomy', 0 );

//create a custom taxonomy name it Skillss for your posts

function create_Type4_hierarchical_taxonomy() {

// Add new taxonomy, make it hierarchical like Skills
//first do the translations part for GUI

$labels = array(
'name' => __( 'Type4', 'acens' ),
'singular_name' => __( 'Type4', 'acens' ),
'search_items' =>  __( 'Search Type4','acens' ),
'all_items' => __( 'All Type4','acens' ),
    'parent_item' => __( 'Parent Type4','acens' ),
    'parent_item_colon' => __( 'Parent Type4:','acens' ),
    'edit_item' => __( 'Edit Type4','acens' ), 
    'update_item' => __( 'Update Type4','acens' ),
    'add_new_item' => __( 'Add New Type4','acens' ),
    'new_item_name' => __( 'New Type4 Name','acens' ),
    'menu_name' => __( 'Type4','acens' ),
  );     

// Now register the taxonomy

  register_taxonomy('Type4',array('Event'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'Type4' ),
  ));

}



?>