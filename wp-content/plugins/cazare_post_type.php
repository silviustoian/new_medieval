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

add_shortcode("cazareform_shortcode", "cazareform_shortcode");
function cazareform_shortcode()
{

    ob_start();
?>

    <?php /* Template Name: My form */

    ?>
    <div class="container" style="width:40%; margin-left: 205px; margin-top: -73px; padding-top: 100px;">
        <form method="post" id="myForm">
            <ul class="form-style-1">
                <li>
                    <label>Titlu <span class="required">*</span></label>
                    <input type="text" name="titlu" id="titlu" class="field-divided" />
                </li>
                <li><label>Full Name <span class="required">*</span></label>
                    <input type="text" name="first_name" id="first_name" class="field-divided" placeholder="First" />
                    <input type="text" name="last_name" id="last_name" class="field-divided" placeholder="Last" /></li>
                <li>
                    <label>Tel <span class="required">*</span></label>
                    <input type="text" name="tel" id="tel" class="field-long" /*pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" */ />
                </li>

                <li>
                    <label>Descriere <span class="required">*</span></label>
                    <textarea name="field5" id="description" class="field-long field-textarea"></textarea>
                </li>

                <li>
                    <input type="submit" value="Submit" />
                </li>

                <input type="hidden" name="action" value="new_post" />
                <?php wp_nonce_field('new-post'); ?>


            </ul>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>


    <script>
        jQuery(function() {
            jQuery('#myForm').submit(function(event) {
                var titlu = jQuery('#titlu').val();
                var first_name = jQuery('#first_name').val();
                var last_name = jQuery('#last_name').val();
                var tel = jQuery('#tel').val();
                var description = jQuery('#description').val();

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: "<?php echo admin_url('admin-ajax.php'); ?>",
                    data: {
                        'action': 'add_new_user',
                        'titlu': titlu,
                        'first_name': first_name,
                        'last_name': last_name,
                        'tel': tel,
                        'description': description
                    },
                    success: function(data) {
                        if (data.res == true) {
                            alert("succes"); // success message
                        } else {
                            alert("fail"); // fail
                        }
                    }
                });
            });
        });
    </script>







    <style type="text/css">
        .form-style-1 {
            margin: 10px auto;
            max-width: 400px;
            padding: 20px 12px 10px 20px;
            font: 13px "Lucida Sans Unicode", "Lucida Grande", sans-serif;
        }

        .form-style-1 li {
            padding: 0;
            display: block;
            list-style: none;
            margin: 10px 0 0 0;
        }

        .form-style-1 label {
            margin: 0 0 3px 0;
            padding: 0px;
            display: block;
            font-weight: bold;
        }

        .form-style-1 input[type=text],
        .form-style-1 input[type=date],
        .form-style-1 input[type=datetime],
        .form-style-1 input[type=number],
        .form-style-1 input[type=search],
        .form-style-1 input[type=time],
        .form-style-1 input[type=url],
        .form-style-1 input[type=email],
        textarea,
        select {
            box-sizing: border-box;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            border: 1px solid #BEBEBE;
            padding: 7px;
            margin: 0px;
            -webkit-transition: all 0.30s ease-in-out;
            -moz-transition: all 0.30s ease-in-out;
            -ms-transition: all 0.30s ease-in-out;
            -o-transition: all 0.30s ease-in-out;
            outline: none;
        }

        .form-style-1 input[type=text]:focus,
        .form-style-1 input[type=date]:focus,
        .form-style-1 input[type=datetime]:focus,
        .form-style-1 input[type=number]:focus,
        .form-style-1 input[type=search]:focus,
        .form-style-1 input[type=time]:focus,
        .form-style-1 input[type=url]:focus,
        .form-style-1 input[type=email]:focus,
        .form-style-1 textarea:focus,
        .form-style-1 select:focus {
            -moz-box-shadow: 0 0 8px #88D5E9;
            -webkit-box-shadow: 0 0 8px #88D5E9;
            box-shadow: 0 0 8px #88D5E9;
            border: 1px solid #88D5E9;
        }

        .form-style-1 .field-divided {
            width: 49%;
        }

        .form-style-1 .field-long {
            width: 100%;
        }

        .form-style-1 .field-select {
            width: 100%;
        }

        .form-style-1 .field-textarea {
            height: 100px;
        }

        .form-style-1 input[type=submit],
        .form-style-1 input[type=button] {
            background: #4B99AD;
            padding: 8px 15px 8px 15px;
            border: none;
            color: #fff;
        }

        .form-style-1 input[type=submit]:hover,
        .form-style-1 input[type=button]:hover {
            background: #4691A4;
            box-shadow: none;
            -moz-box-shadow: none;
            -webkit-box-shadow: none;
        }

        .form-style-1 .required {
            color: red;
        }
    </style>





<?php
    return ob_get_clean();
}
add_action('wp_ajax_nopriv_add_new_user', 'add_new_user');
add_action('wp_ajax_add_new_user', 'add_new_user');
function add_new_user()
{
	global $wpdb;

	$titlu = sanitize_text_field($_POST["titlu"]);
	$first_name = sanitize_text_field($_POST["first_name"]);
	$last_name = sanitize_text_field($_POST["last_name"]);
	$tel = sanitize_text_field($_POST["tel"]);
	$description = sanitize_text_field($_POST["description"]);


	$tableName = 'cazare_entry';
	$insert_row = $wpdb->insert(
		$tableName,
		array(
			'titlu' => $titlu,
			'first_name' => $first_name,
			'last_name' => $last_name,
			'tel' => $tel,
			'description' => $description

		)
	);
	// if row inserted in table
	if ($insert_row) {
		echo json_encode(array('res' => true, 'message' => __('New row has been inserted.')));
	} else {
		echo json_encode(array('res' => false, 'message' => __('Something went wrong. Please try again later.')));
	}
	wp_die();
}
?>

