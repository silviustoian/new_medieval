<?php

/**
 * Neve functions.php file
 *
 * Author:          Andrei Baicus <andrei@themeisle.com>
 * Created on:      17/08/2018
 *
 * @package Neve
 */

/////////FORM INSERT



define('NEVE_VERSION', '2.5.4');
define('NEVE_INC_DIR', trailingslashit(get_template_directory()) . 'inc/');
define('NEVE_ASSETS_URL', trailingslashit(get_template_directory_uri()) . 'assets/');

if (!defined('NEVE_DEBUG')) {
	define('NEVE_DEBUG', false);
}

/**
 * Themeisle SDK filter.
 *
 * @param array $products products array.
 *
 * @return array
 */
function neve_filter_sdk($products)
{
	$products[] = get_template_directory() . '/style.css';

	return $products;
}

add_filter('themeisle_sdk_products', 'neve_filter_sdk');

add_filter('themeisle_onboarding_phprequired_text', 'neve_get_php_notice_text');

/**
 * Get php version notice text.
 *
 * @return string
 */
function neve_get_php_notice_text()
{
	$message = sprintf(
		/* translators: %s message to upgrade PHP to the latest version */
		__("Hey, we've noticed that you're running an outdated version of PHP which is no longer supported. Make sure your site is fast and secure, by %s. Neve's minimal requirement is PHP 5.4.0.", 'neve'),
		sprintf(
			/* translators: %s message to upgrade PHP to the latest version */
			'<a href="https://wordpress.org/support/upgrade-php/">%s</a>',
			__('upgrading PHP to the latest version', 'neve')
		)
	);

	return wp_kses_post($message);
}

/**
 * Adds notice for PHP < 5.3.29 hosts.
 */
function neve_php_support()
{
	printf('<div class="error"><p>%1$s</p></div>', neve_get_php_notice_text()); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

if (version_compare(PHP_VERSION, '5.3.29') <= 0) {
	/**
	 * Add notice for PHP upgrade.
	 */
	add_filter('template_include', '__return_null', 99);
	switch_theme(WP_DEFAULT_THEME);
	unset($_GET['activated']);
	add_action('admin_notices', 'neve_php_support');

	return;
}

require_once get_template_directory() . '/start.php';

require_once 'globals/utilities.php';
require_once 'globals/hooks.php';
require_once 'globals/sanitize-functions.php';
require_once 'globals/migrations.php';

require_once get_template_directory() . '/header-footer-grid/loader.php';

///send ajax to DB
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


include(get_stylesheet_directory() . './cazareform_shortcode.php');


////send form to custom post type
if ('POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST['action']) &&  $_POST['action'] == "new_post") {

	// Do some minor form validation to make sure there is content
	if (isset($_POST['titlu'])) {
		$titlu =  $_POST['titlu'];
	} else {
		echo 'Please enter a  title';
	}
	if (isset($_POST['first_name'])) {
		$first_name = $_POST['first_name'];
	} else {
		echo 'Please enter first name';
	}
	if (isset($_POST['last_name'])) {
		$last_name = $_POST['last_name'];
	} else {
		echo 'Please enter last name';
	}
	if (isset($_POST['tel'])) {
		$tel = $_POST['tel'];
	} else {
		echo 'Please enter tel';
	}

	// Add the content of the form to $post as an array
	$new_post = array(
		'post_title'    => $titlu,
		'post_content'  => $description,
		'post_status'   => 'publish',           // Choose: publish, preview, future, draft, etc.
		'post_type' => 'Cazari'  //'post',page' or use a custom post type if you want to
	);
	//save the new post
	$pid = wp_insert_post($new_post);
	//insert taxonomies
}
