<?php

class Coprime {

	use Nexus_Singleton;

	private function __construct() {
		add_action('after_setup_theme', array($this, 'setup_theme'), 16);

		if ( current_user_can('administrator') ) {
			add_action('in_footer', array($this, 'admin_statistics'));
		}

	}

	public function setup_theme() {
		add_theme_support('menus');
		$this->register_menus();

		// Load public-facing style sheet and JavaScript.
		add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));

		add_filter('body_class', array($this, 'add_body_classes'));

		// clears series list data from cache
		add_action('save_post', array($this, 'update_series_list_data'), 1, 2);
	}


	public function enqueue_styles() {
		wp_register_style('open-sans', 'http://fonts.googleapis.com/css?family=Open+Sans:400,700');
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

	public function get_person_episodes($post_id) {
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$arguments = array(
			'post_type' => 'episode',
			'posts_per_page' => 20,
			'paged' => $paged,
			'meta_value' => $post_id
		);
		$query = new WP_Query($arguments);
		return $query;
	}

	public function get_series_list_query() {

		$post_ids = get_transient('coprime_get_series_list_query');
		if ( false === $post_ids ) {
			$post_ids = $this->get_series_list_data();
			set_transient('coprime_get_series_list_query', $post_ids, 60 * 60 * 12);
		}

		return $post_ids;
	}

	private function get_series_list_data() {
		$arguments = array(
			'orderby' => 'name',
			'hide_empty' => 1,
		);
		$categories = get_categories($arguments);
		$post_ids = array(); // store a list of IDs that represent the latest from each category
		$query = new WP_Query();
		foreach ($categories as $category) {
			if ( in_array(strtolower($category->cat_name), array('uncategorized')) ) continue;
			$query->query(array(
				'post_type' => 'episode',
				'posts_per_page' => 1,
				'cat' => $category->term_id
			));
			$query->the_post();
			$id = get_the_ID(); // this is awful
			if ( is_numeric($id) ) $post_ids[] = $id;
		}
		wp_reset_postdata();
		return $post_ids;
	}

	public function update_series_list_data($post_id, $post) {
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return $post_id;
		if ( $post->post_type == 'episode' ) {
			delete_transient('coprime_get_series_list_query');
		}
	}

	public function admin_statistics() {
		$timer = timer_stop(0, 2);
		$queries = get_num_queries();
		$content = "{$timer} seconds | {$queries} queries";
		$template = "<div style=\"margin: 1em;\" class=\"statistics\">{$content}</div>";
		echo $template;
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