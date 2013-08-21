<?php

class Coprime {

	use Nexus_Singleton;

	private function __construct() {

		add_theme_support( 'post-thumbnails', array('episode'));   

		add_theme_support('menus');
		$this->register_menus();

		// Load public-facing style sheet and JavaScript.
		add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));		

		add_filter('body_class', array($this, 'add_body_classes'));

	}

	public function enqueue_styles() {
		wp_register_style('open-sans', 'http://fonts.googleapis.com/css?family=Exo:400,700|Montserrat|Open+Sans:400,700');
		wp_register_style('coprime', get_stylesheet_directory_uri() . '/library/css/style.css', array(), '', 'all' );

		wp_enqueue_style('open-sans');
		wp_enqueue_style('coprime');
	}

	public function enqueue_scripts() {
		wp_enqueue_script( 'coprime-script', get_stylesheet_directory_uri() . '/library/js/script.js', array( 'jquery' ) );
	}

	public function register_menus() {
		$menus = array(
			'primary' => 'Primary Menu',
			'footer' => 'Footer Menu'
		);
		register_nav_menus($menus);
		add_action('after_identity', array($this, 'register_primary_menu'));
	}

	public function register_primary_menu() {
		$settings = array(
			'menu' => 'primary',
			'container' => 'nav',
			'container_id' => 'primary-menu'
		);
		wp_nav_menu($settings);
	}

	public function add_body_classes($classes) {
		$classes[] = 'coprime';
		$classes[] = 'small-identity';
		return $classes;
	}


	public function get_villain_query() {
		$arguments = array(
	        'post_type' => 'episode',
	        'posts_per_page' => 3
	    );
	    $arguments = $this->exclude_fringe($arguments);
	    $query = new WP_Query($arguments);
	    return $query;
	}

	public function get_showboard_primary_query($post_ids = array()) {
		$arguments = array(
	        'post_type' => 'episode',
	        'posts_per_page' => 6,
	        'post__not_in' => $post_ids
	    );
	    $arguments = $this->exclude_fringe($arguments);
	    $query = new WP_Query($arguments);
	    return $query;
	}

	public function get_showboard_fringe_query() {
		$arguments = array(
	        'post_type' => 'episode',
	        'posts_per_page' => 3,
	        'category_name' => 'tf'
	    );
	    $query = new WP_Query($arguments);
	    return $query;
	}

	private function exclude_fringe($arguments = array()) {
		$fringe = get_category_by_slug('tf');
		if ( !$fringe ) return $arguments;
		if ( isset($arguments['category__not_in']) ) {
			$arguments['category__not_in'] = array_merge($arguments['category__not_in'], array($fringe->term_id));
		} else {
			$arguments['category__not_in'] = array($fringe->term_id);
		}
		return $arguments;
	} 	


}