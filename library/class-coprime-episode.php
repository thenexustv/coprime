<?php


class Coprime_Episode {

	private $episode;

	public function __construct(Nexus_Episode $episode) {
		$this->episode = $episode;
	}

	private function classes_array_to_string($array = array()) {
		if ( is_string($array) ) $array = array($array);
		$string = trim(join(' ', $array));
		return $string;
	}

	private function wrap($content, $classes = array(), $tag = 'span') {
		$class_string = $this->classes_array_to_string($classes);
		return "<{$tag} class=\"{$class_string}\">$content</{$tag}>";
	}

	private function get_title_length_class($title) {
		$class = 'regular';

		$length = strlen($title);
		if ( $length > 66 ) {$class = 'epic-long';}
		else if ($length > 33) {$class = 'long';}

		return $class;
	}

	public function get_title() {
		$title = $this->episode->get_title();

		$class = $this->get_title_length_class($title);		

		$template = "<a class=\"{$class}\" href=\"{$this->episode->get_permalink()}\">{$title}</a>";
		return $this->wrap($template, array('episode-title', 'entry-title'));
	}

	public function get_formatted_title() {
		$title = $this->episode->get_formatted_title();
	
		$class = $this->get_title_length_class($title);

		$template = "<a class=\"{$class}\" href=\"{$this->episode->get_permalink()}\">{$title}</a>";
		return $this->wrap($template, array('episode-title', 'episode-formatted-title', 'entry-title'));
	}

	public function get_villain_title() {
		$title = $this->episode->get_title();
		$class = 'regular';

		$length = strlen($title);
		if ($length > 45) {$class = 'epic-long';}
		elseif ( $length > 30 ) {$class = 'long';}

		$template = "{$title}";
		return $this->wrap($template, array('episode-title', $class));
	}

	public function get_single_title() {
		$classes = apply_filters('coprime_episode_get_single_title', array('episode-single-title'));
		$number = ( $this->episode->get_episode_number() ? $this->wrap("#{$this->get_episode_number()}: ", array('episode-pound')) : '');
		$title = $this->get_title();
		return $this->wrap("{$number}{$title}");
	}

	public function get_episode_number() {
		$number = apply_filters('coprime_episode_get_number', $this->episode->get_episode_number());
		$classes = apply_filters('coprime_episode_get_number_classes', array('episode-number'));
		return $this->wrap($number, $classes);
	}

	public function get_with_fringe() {
		$fringe_id = $this->episode->get_fringe();
		if (!$fringe_id) return '';
		$fringe = Nexus_Episode::factory($fringe_id);
		$template = " &blacksquare; <a title=\"{$fringe->get_title()}\" href=\"{$fringe->get_permalink()}\">The Fringe #{$fringe->get_episode_number()}</a>";
		return $this->wrap($template, 'with-fringe');
	}

	public function get_with_parent() {
		$parent_id = $this->episode->get_parent();
		if (!$parent_id) return '';
		$parent = Nexus_Episode::factory($parent_id);
		$slug = strtoupper($parent->get_series()->get_slug());
		$template = " &blacksquare; <a title=\"{$parent->get_title()}\" href=\"{$parent->get_permalink()}\">{$slug} #{$parent->get_episode_number()}</a>";
		return $this->wrap($template, 'with-parent');
	}

	public function get_with_related_episode() {

		return "{$this->get_with_fringe()} {$this->get_with_parent()}";

	}

	public function get_episode_position() {
		return "Episode #{$this->get_episode_number()}{$this->get_with_related_episode()}";
	}

	public function get_posted_date() {
		$date = $this->episode->get_posted_date('F j');
		$raw = $this->episode->get_posted_date('r');

		$template = "<time datetime=\"{$raw}\">{$date}</time>";

		$variables = array('date', 'raw');
		$values = compact($variables);

		$template = apply_filters('get_posted_date_ago_template', $template, $values, $this);

		return $this->wrap($template, array('episode-date', 'updated' , 'date'));
	}

	public function get_posted_date_ago() {
		$diff = Nexus_Utility::human_time_difference( $this->episode->get_posted_date('U'), current_time('timestamp') ) ;
		$date = $this->episode->get_posted_date('F jS Y');
		$raw = $this->episode->get_posted_date('r');
		$ago = "$diff ago";

		$template = "<time datetime=\"{$raw}\">{$date} &blacksquare; <span class=\"ago\">{$ago}</span></time>";

		$variables = array('diff', 'date', 'raw', 'ago');
		$values = compact($variables);

		$template = apply_filters('get_posted_date_ago_template', $template, $values, $this);

		return $this->wrap($template, array('episode-date', 'updated', 'date'));
	}

	public function get_episode_description() {
		$excerpt = $this->get_episode_excerpt();
		$description = apply_filters('get_episode_description', $excerpt);
		return $this->wrap($description, 'episode-description', 'div');
	}

	public function get_episode_excerpt($trim = false) {
		$excerpt = $this->episode->get_excerpt();
		if (  is_integer($trim) && $trim > 0 ) {
			$excerpt = wp_trim_words($excerpt, $trim);
		}
		return $excerpt;
	}

	/*
		This function exists to enforce compliance with hAtom and Google.
	*/
	public function get_episode_author() {
		$author = get_the_author_meta('display_name', $this->episode->get_post()->post_author);
		echo $author;
	}

	public function get_podcast_player($enclosure) {

		$enclosure = apply_filters('get_podcast_player_enclosure', $enclosure);
		$file = $enclosure['url'];
		$shortcode = "[audio mp3=\"$file\"]";

		$template = do_shortcode($shortcode);
		return $this->wrap($template, 'episode-player', 'div');

	}

	public function get_is_new($tolerance = 14) {
		$new = $this->episode->is_new($tolerance);
		$template = "New";
		if ($new) return $this->wrap($template, 'episode-new', 'span');
		return '';
	}

	public function get_podcast_meta($enclosure) {
		$enclosure = apply_filters('get_podcast_meta_enclosure', $enclosure);

		$duration = apply_filters('get_podcast_meta_duration', Nexus_Utility::human_duration($enclosure['duration']));
		$size = apply_filters('get_podcast_meta_size', Nexus_Utility::human_filesize($enclosure['size']));
		$url = apply_filters('get_podcast_meta_url', $enclosure['url']);

		$template_duration = $this->wrap($duration, 'episode-duration');
		$template_size = $this->wrap($size, 'episode-size');
		$template_download = $this->wrap("<a href=\"{$url}\">Download</a>", 'episode-download');

		$template = "{$template_duration} &blacksquare; {$template_size} &blacksquare; {$template_download}";
		$template = apply_filters('get_podcast_meta_template', $template);

		return $this->wrap($template, 'episode-download-meta', 'div');

	}

	public function get_hero_albumart() {
		$image = $this->episode->get_albumart(array('size' => 'medium'));
		$excerpt = esc_attr(strip_tags($this->get_episode_excerpt(20)));

		if ( $image )
			$template = "<a href=\"{$this->episode->get_permalink()}\"><img title=\"{$excerpt}\" src=\"{$image['url']}\" class=\"{$image['class']}\" /></a>";
		else
			$template = "<div><!-- the hero is missing --></div>";
		
		return $this->wrap($template, 'episode-albumart', 'div');
	}

	public function get_showboard_albumart() {
		$image = $this->episode->get_albumart(array('size' => 'medium'));
		$excerpt = esc_attr(strip_tags($this->get_episode_excerpt(20)));

		if ( $image )
			$template = "<a href=\"{$this->episode->get_permalink()}\"><img title=\"{$excerpt}\" src=\"{$image['url']}\" class=\"{$image['class']}\" /></a>";
		else
			$template = "<div><!-- showboard is missing --></div>";
		
		return $this->wrap($template, 'episode-albumart', 'div');
	}

	public function get_series_list_albumart() {
		$image = $this->episode->get_albumart(array('size' => 'thumbnail'));

		$url = $this->episode->get_series()->get_permalink();
		if ( empty($url) ) $url = $this->episode->get_permalink();

		if ( $image )
			$template = "<a href=\"{$url}\"><img alt=\"The {$this->episode->get_series_name()} series\"src=\"{$image['url']}\" class=\"{$image['class']}\" /></a>";
		else
			$template = "<div><!-- --></div>";
		
		return $this->wrap($template, 'episode-albumart', 'div');
	}

	// villain needs raw urls
	public function get_villain_albumart() {
		$image = $this->episode->get_albumart(array('size' => 'large'));
		return $image['url'];
	}

	public function get_contact_link() {
		if ( defined('WPCF7_VERSION') && $this->episode->is_fringe() ) return '';
		$name = $this->episode->get_series_name();
		$contact_url = $this->episode->get_contact_url();
		$template = "<a title=\"Send Feedback to {$name}\" href=\"{$contact_url}\">Contact <em>{$name}</em></a>";
		$output = $this->wrap($template, 'send-feedback', 'span');
		return $output;
	}

}
