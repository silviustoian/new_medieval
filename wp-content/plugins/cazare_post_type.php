<?php
/* 
    Plugin Name: Silviu Custom Post
    */
function custom_post_type()
{

    $labels = array(
        'name'                  => _x('Cazari', 'Post Type General Name', 'text_domain'),
        'singular_name'         => _x('Cazari', 'Post Type Singular Name', 'text_domain'),
        'menu_name'             => __('Cazari', 'text_domain'),
        'name_admin_bar'        => __('Cazari', 'text_domain'),
        'archives'              => __('Item Archives', 'text_domain'),
        'attributes'            => __('Item Attributes', 'text_domain'),
        'parent_item_colon'     => __('Parent Item:', 'text_domain'),
        'all_items'             => __('All Items', 'text_domain'),
        'add_new_item'          => __('Add New Item', 'text_domain'),
        'add_new'               => __('Add New', 'text_domain'),
        'new_item'              => __('New Item', 'text_domain'),
        'edit_item'             => __('Edit Item', 'text_domain'),
        'update_item'           => __('Update Item', 'text_domain'),
        'view_item'             => __('View Item', 'text_domain'),
        'view_items'            => __('View Items', 'text_domain'),
        'search_items'          => __('Search Item', 'text_domain'),
        'not_found'             => __('Not found', 'text_domain'),
        'not_found_in_trash'    => __('Not found in Trash', 'text_domain'),
        'featured_image'        => __('Featured Image', 'text_domain'),
        'set_featured_image'    => __('Set featured image', 'text_domain'),
        'remove_featured_image' => __('Remove featured image', 'text_domain'),
        'use_featured_image'    => __('Use as featured image', 'text_domain'),
        'insert_into_item'      => __('Insert into item', 'text_domain'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'text_domain'),
        'items_list'            => __('Items list', 'text_domain'),
        'items_list_navigation' => __('Items list navigation', 'text_domain'),
        'filter_items_list'     => __('Filter items list', 'text_domain'),
    );
    $args = array(
        'label'                 => __('Cazari', 'text_domain'),
        'description'           => __('Cazari', 'text_domain'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'comments', 'custom-fields'),
        'taxonomies'            => array('category', 'post_tag'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',

    );
    register_post_type('Cazari', $args);
}
add_action('init', 'custom_post_type', 0);


add_shortcode('qg_shortcode', 'qg_shortcode');
function qg_shortcode()
{
    $args = array('post_type' => 'Cazari');
    $the_query = new WP_Query($args);

    // The Loop
    if ($the_query->have_posts()) {
        echo '<ul>';
        echo '<h3>Cazari - Titlu</h3>';
        while ($the_query->have_posts()) {
            $the_query->the_post();

            echo '<li>' . get_the_title() . '</li>';
        }
        echo '</ul>';
        echo '<ul>';
        echo '<h3>Cazari - Content</h3>';
        while ($the_query->have_posts()) {
            $the_query->the_post();

            echo '<li>' . get_the_content() . '</li>';
        }
        echo '</ul>';
        /* Restore original Post Data */
        wp_reset_postdata();
    } else {
        // no posts found
    }
}

add_shortcode('sos_shortcode', 'sos_shortcode');
function sos_shortcode($args)
{
    global $wpdb;
    // Shortcodes RETURN content, so store in a variable to return
    $content = '<table>';
    $content .= '<h3>Cazari</h3>';
    $results = $wpdb->get_results( ' SELECT * FROM cazare_entry' );
    foreach ( $results AS $row ) {
        $content .= '<tr>';
        // Modify these to match the database structure
        $content .= '<td>' . $row->{'Week Beginning'} . '</td>';
        $content .= '<td>' . $row->titlu . '</td>';
        $content .= '<td>' . $row->first_name . '</td>';
        $content .= '<td>' . $row->last_name . '</td>';
        $content .= '<td>' . $row->tel . '</td>';
        $content .= '<td>' . $row->description . '</td>';
        $content .= '</tr>';
    }
    $content .= '</table>';

    // return the table
    return $content;
}