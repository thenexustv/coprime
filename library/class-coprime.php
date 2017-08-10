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

		add_action('widgets_init', array($this, 'register_sidebars'));

		// Load public-facing style sheet and JavaScript.
		add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));

		add_filter('body_class', array($this, 'add_body_classes'));

		// clears series list data from cache
		add_action('save_post', array($this, 'update_series_list_data'), 1, 2);

		add_action('wp_head', array($this, 'headers'));
	}

	public function headers() {
		echo "<meta property=\"fb:admins\" content=\"793140430\" />\n";
	}

	public function enqueue_styles() {
		wp_register_style('open-sans', 'http://fonts.googleapis.com/css?family=Open+Sans:400,700');
		wp_register_style('coprime', get_stylesheet_directory_uri() . '/resources/css/build/style.css', array(), '', 'all' );

		wp_enqueue_style('open-sans');
		wp_enqueue_style('coprime');
	}

	public function enqueue_scripts() {
		wp_enqueue_script( 'coprime-script', get_stylesheet_directory_uri() . '/resources/js/build/main.js', array( 'jquery' ) );
	}

	public function register_menus() {
		$menus = array(
			'primary' => 'Primary Menu',
			'footer' => 'Footer Menu'
		);
		register_nav_menus($menus);
		add_action('after_identity', array($this, 'register_primary_menu'));
	}

	public function register_sidebars() {
		$footer_area = array(
			'name' => 'Footer Area',
			'id' => 'footer-area',
			'description' => 'Contains widgets in the footer',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>'
		);
		register_sidebar($footer_area);
	}

	public function get_widget_count($id = '') {
		if ( $id == '' ) return 0;
		$sidebars = wp_get_sidebars_widgets();
		if (!isset($sidebars[$id])) return 0;
		return count($sidebars[$id]);
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

		function _is_april() {
			$now = time();
			$begin = strtotime("2014-03-31 12:00:00");
			$end = strtotime("2014-04-02 12:00:00");
			if ( $now >= $begin && $now <= $end ) {
				return true;
			}
			return false;
		}

		// if ( _is_april() ) {
		// 	$classes[] = 'april-fools';
		// }

		return $classes;
	}

	public function get_single_recent_episode() {
		$arguments = array(
	        'post_type' => 'episode',
	        'posts_per_page' => 1,
	        'order' => 'DESC'
	    );
	    $arguments = $this->exclude_fringe($arguments);
	    $query = new WP_Query($arguments);
	    $posts = $query->get_posts();

	    return $posts[0];

	}

	public function get_villain_query($how_many = 3) {
		
        $villain_map = array(
            'dictator' => 1,
            'diarchy' => 2,
            'triumvirate' => 3
        );
        $mode = 'triumvirate';

		$arguments = array(
	        'post_type' => 'episode',
	        'posts_per_page' => intval($how_many),
	        'order' => 'DESC'
	    );

	    $arguments = $this->exclude_fringe($arguments);
	    $ago = date('y-m-d', strtotime('-336 hours'));
	    $now = date('y-m-d', strtotime('+1 day'));

	    $fn = function($where = '') use ($ago, $now) {
	    	$where .= "AND post_date >= '$ago' AND post_date < '$now'";
	    	return $where;
	    };

	    add_filter('posts_where', $fn);
	    $query = new WP_Query($arguments);
	    remove_filter('posts_where', $fn);

	    // decide on the mode
	    foreach ($villain_map as $key => $value) {
	    	if ($query->post_count == $value) {
	    		$mode = $key;
	    		break;
	    	}
	    }

	    // if there are no new posts, perform a new query with posts in it, unfortunately
	    if ( $query->post_count == 0 ) {
	    	$query = new WP_Query($arguments);
	    	return array('mode' => $mode, 'query' => $query);
	    }

	    return array('mode' => $mode, 'query' => $query);
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

		// http://www.php.net/manual/en/function.memory-get-usage.php#96280
		function convert($size) {
			$unit=array('B','KiB','MiB','GiB','TiB','PiB');
			return @round($size/pow(1024,($i=floor(log($size,1024)))),3).' '.$unit[$i];
		}

		$timer = timer_stop(0, 2);
		$queries = get_num_queries();
		$memory = convert(memory_get_usage(true));
		$content = "{$timer} seconds &blacksquare; {$queries} queries &blacksquare; {$memory}";
		$template = "<div class=\"admin-statistics\">{$content}</div>";
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
