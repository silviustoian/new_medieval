<?php
/**
 * Handles Magic Tags
 *
 * @package Neve
 */

namespace HFG\Core;

/**
 * Class Short_Codes
 *
 * @package Neve\Views\Pluggable
 */
class Magic_Tags {
	/**
	 * The magic tags options used for Customizer.
	 *
	 * @var array
	 */
	private $options = [];

	/**
	 * Available short codes.
	 *
	 * @var array
	 */
	private $magic_tags = [];

	/**
	 * Magic tag regex.
	 *
	 * @var string
	 */
	static private $magic_tag_regex;

	/**
	 * Holds the instance of the class.
	 *
	 * @var Magic_Tags
	 */
	static private $_instance;

	/**
	 * Returns the instance of the class.
	 *
	 * @return Magic_Tags
	 */
	public static function get_instance() {
		if ( null === self::$_instance ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Function that is run after instantiation.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->setup_config();
		if ( class_exists( 'WooCommerce', false ) ) {
			$this->magic_tags = array_merge(
				$this->magic_tags,
				[
					'product_price',
					'product_title',
					'cart_link',
					'checkout_link',
				]
			);
		}
		self::$magic_tag_regex = implode( '|', $this->magic_tags );
	}

	/**
	 * Do the magic tags inside the string.
	 *
	 * @param string $input the input.
	 *
	 * @return string|
	 */
	public function do_magic_tags( $input ) {
		if ( empty( self::$magic_tag_regex ) ) {
			return $input;
		}

		if ( ! preg_match( '/\\{\\s?\\w+\\s?\\}/', $input ) ) {
			return $input;
		}

		return preg_replace_callback(
			'/\\{\s?\b(?:' . self::$magic_tag_regex . ')\b\s?\\}/',
			[
				$this,
				'do_magic_tag',
			],
			$input
		);
	}

	/**
	 * Do single magic tag.
	 *
	 * @param string $tag the magic tag.
	 *
	 * @return string
	 */
	private function do_magic_tag( $tag ) {
		if ( is_array( $tag ) ) {
			$tag = reset( $tag );
		}

		$tag = trim( $tag, '{} ' );

		if ( ! method_exists( $this, $tag ) ) {
			return '';
		}

		return wp_kses_post( call_user_func( [ $this, $tag ] ) );
	}

	/**
	 * Single title.
	 *
	 * @return string
	 */
	public function current_single_title() {
		return is_singular() ? get_the_title() : '';
	}

	/**
	 * Single Excerpt.
	 *
	 * @return string
	 */
	public function current_single_excerpt() {
		return is_singular() ? get_the_excerpt() : '';
	}

	/**
	 * Archive Description.
	 *
	 * @return string
	 */
	public function archive_description() {
		return get_the_archive_description();
	}

	/**
	 * Archive Title.
	 *
	 * @return string
	 */
	public function archive_title() {
		return html_entity_decode( get_the_archive_title() );
	}

	/**
	 * Site Title.
	 *
	 * @return string
	 */
	public function site_title() {
		return get_bloginfo( 'title' );
	}

	/**
	 * Site Tagline.
	 *
	 * @return string
	 */
	public function site_tagline() {
		return get_bloginfo( 'description' );
	}

	/**
	 * Author Bio.
	 *
	 * @return string
	 */
	public function author_bio() {
		return get_the_author_meta( 'description', get_post_field( 'post_author', get_the_ID() ) );
	}

	/**
	 * Author Name.
	 *
	 * @return string
	 */
	public function author_name() {
		return get_the_author_meta( 'display_name', get_post_field( 'post_author', get_the_ID() ) );
	}

	/**
	 * Single URL.
	 *
	 * @return string
	 */
	public function current_single_url() {
		return is_singular() ? get_permalink() : '';
	}

	/**
	 * Home URL.
	 *
	 * @return string
	 */
	public function home_url() {
		return get_home_url();
	}

	/**
	 * Archive URL.
	 *
	 * @return string
	 */
	public function archive_url() {
		return get_post_type_archive_link( get_post_field( 'post_type' ) );
	}

	/**
	 * Author URL.
	 *
	 * @return string
	 */
	public function author_url() {
		return get_author_posts_url( get_post_field( 'post_author', get_the_ID() ) );
	}

	/**
	 * Current Year.
	 *
	 * @return string
	 */
	public function current_year() {
		return date( 'Y' );
	}

	/**
	 * Product Price.
	 *
	 * @return string
	 */
	public function product_price() {
		if ( ! class_exists( 'WooCommerce', false ) ) {
			return '';
		}
		$product = wc_get_product( get_the_ID() );

		return is_singular( 'product' ) ? wc_price( $product->get_price() ) : '';
	}

	/**
	 * Product Title.
	 *
	 * @return string
	 */
	public function product_title() {
		if ( ! class_exists( 'WooCommerce', false ) ) {
			return '';
		}
		$product = wc_get_product( get_the_ID() );

		return is_singular( 'product' ) ? $product->get_title() : '';
	}

	/**
	 * Cart Link.
	 *
	 * @return string
	 */
	public function cart_link() {
		if ( ! class_exists( 'WooCommerce', false ) ) {
			return '';
		}

		return wc_get_cart_url();
	}

	/**
	 * Checkout Link.
	 *
	 * @return string
	 */
	public function checkout_link() {
		if ( ! class_exists( 'WooCommerce', false ) ) {
			return '';
		}

		return wc_get_checkout_url();
	}

	/**
	 * Get the options array.
	 *
	 * @return mixed
	 */
	public function get_options() {
		return $this->options;
	}

	/**
	 * Setup the magic tags config and options array.
	 */
	private function setup_config() {
		$this->options = [
			[
				'label'    => __( 'Single', 'neve' ),
				'controls' => [
					'current_single_title'   => [
						'label' => __( 'Current Single Title', 'neve' ),
						'type'  => 'string',
					],
					'current_single_excerpt' => [
						'label' => __( 'Current Single Excerpt', 'neve' ),
						'type'  => 'string',
					],
					'current_single_url'     => [
						'label' => __( 'Current Single URL', 'neve' ),
						'type'  => 'url',
					],
				],
			],
			[
				'label'    => __( 'Archive', 'neve' ),
				'controls' => [
					'archive_description' => [
						'label' => __( 'Archive Description', 'neve' ),
						'type'  => 'string',
					],
					'archive_title'       => [
						'label' => __( 'Archive Title', 'neve' ),
						'type'  => 'string',
					],
					'archive_url'         => [
						'label' => __( 'Archive URL', 'neve' ),
						'type'  => 'url',
					],
				],
			],
			[
				'label'    => __( 'Author', 'neve' ),
				'controls' => [
					'author_bio'  => [
						'label' => __( 'Author Bio', 'neve' ),
						'type'  => 'string',
					],
					'author_name' => [
						'label' => __( 'Author Name', 'neve' ),
						'type'  => 'string',
					],
					'author_url'  => [
						'label' => __( 'Author URL', 'neve' ),
						'type'  => 'url',
					],
				],
			],
			[
				'label'    => __( 'Global', 'neve' ),
				'controls' => [
					'site_title'   => [
						'label' => __( 'Site Title', 'neve' ),
						'type'  => 'string',
					],
					'site_tagline' => [
						'label' => __( 'Site Tagline', 'neve' ),
						'type'  => 'string',
					],
					'home_url'     => [
						'label' => __( 'Home URL', 'neve' ),
						'type'  => 'url',
					],
					'current_year' => [
						'label' => __( 'Current Year', 'neve' ),
						'type'  => 'string',
					],
				],
			],
		];

		if ( class_exists( 'WooCommerce', false ) ) {
			$this->options[] = [
				'label'    => __( 'WooCommerce', 'neve' ),
				'controls' => [
					'product_price' => [
						'label' => __( 'Product Price', 'neve' ),
						'type'  => 'string',
					],
					'product_title' => [
						'label' => __( 'Product Title', 'neve' ),
						'type'  => 'string',
					],
					'cart_link'     => [
						'label' => __( 'Cart URL', 'neve' ),
						'type'  => 'url',
					],
					'checkout_link' => [
						'label' => __( 'Checkout URL', 'neve' ),
						'type'  => 'url',
					],
				],
			];
		}

		foreach ( $this->options as $magic_tag_group => $args ) {
			foreach ( $args['controls'] as $tag => $tag_args ) {
				$this->magic_tags[] = $tag;
			}
		}
	}
}
