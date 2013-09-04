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

	public function get_title() {
		$title = $this->episode->get_title();
		$class = 'regular';

		$length = strlen($title);
		if ( $length > 33 ) {$class = 'long';}
		else if ($length > 66) {$class = 'epic-long';}

		$template = "<a class=\"{$class}\" href=\"{$this->episode->get_permalink()}\">{$title}</a>";
		return $this->wrap($template, 'episode-title');
	}

	public function get_formatted_title() {
		$title = $this->episode->get_formatted_title();
		$class = 'regular';

		$length = strlen($title);
		if ( $length > 33 ) {$class = 'long';}
		else if ($length > 66) {$class = 'epic-long';}

		$template = "<a class=\"{$class}\" href=\"{$this->episode->get_permalink()}\">{$title}</a>";
		return $this->wrap($template, array('episode-title', 'episode-formatted-title'));
	}

	public function get_villain_title() {
		$title = $this->episode->get_title();
		$class = 'regular';

		$length = strlen($title);
		if ( $length > 30 ) {$class = 'long';}
		else if ($length > 45) {$class = 'epic-long';}

		$template = "{$title}";
		return $this->wrap($template, 'episode-title');
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
		$template = " &blacksquare; <a href=\"{$fringe->get_permalink()}\">The Fringe #{$fringe->get_episode_number()}</a>";
		return $this->wrap($template, 'with-fringe');
	}

	public function get_episode_position() {
		return "Episode #{$this->get_episode_number()}{$this->get_with_fringe()}";
	}

	public function get_posted_date() {
		$date = $this->episode->get_posted_date('F j');
		$raw = $this->episode->get_posted_date('r');

		$template = "<time datetime=\"{$raw}\">{$date}</time>";

		$variables = array('date', 'raw');
		$values = compact($variables);

		$template = apply_filters('get_posted_date_ago_template', $template, $values, $this);

		return $this->wrap($template, 'episode-date');
	}

	public function get_posted_date_ago() {
		$diff = Nexus_Core::human_time_difference( $this->episode->get_posted_date('U'), current_time('timestamp') ) ;
		$date = $this->episode->get_posted_date('F jS Y');
		$raw = $this->episode->get_posted_date('r');
		$ago = "$diff ago";

		$template = "<time datetime=\"{$raw}\">{$date} &blacksquare; {$ago}</time>";

		$variables = array('diff', 'date', 'raw', 'ago');
		$values = compact($variables);

		$template = apply_filters('get_posted_date_ago_template', $template, $values, $this);

		return $this->wrap($template, 'episode-date');
	}

	public function get_episode_description() {
		$description = apply_filters('get_episode_description', $this->episode->get_excerpt());
		return $this->wrap($description, 'episode-description', 'div');
	}

	public function get_podcast_player($enclosure) {

		$enclosure = apply_filters('get_podcast_player_enclosure', $enclosure);
		$file = $enclosure['url'];
		$shortcode = "[audio mp3=\"$file\"]";

		$template = do_shortcode($shortcode);
		return $this->wrap($template, 'episode-player', 'div');

	}

	public function get_is_new($tolerance = 5) {
		$new = $this->episode->is_new($tolerance);
		$template = "New";
		if ($new) return $this->wrap($template, 'episode-new', 'span');
		return '';
	}

	public function get_podcast_meta($enclosure) {
		$enclosure = apply_filters('get_podcast_meta_enclosure', $enclosure);

		$duration = apply_filters('get_podcast_meta_duration', Nexus_Core::human_duration($enclosure['duration']));
		$size = apply_filters('get_podcast_meta_size', Nexus_Core::human_filesize($enclosure['size']));
		$url = apply_filters('get_podcast_meta_url', $enclosure['url']);

		$template_duration = $this->wrap($duration, 'episode-duration');
		$template_size = $this->wrap($size, 'episode-size');
		$template_download = $this->wrap("<a href=\"{$url}\">Download</a>", 'episode-download');

		$template = "{$template_duration} &blacksquare; {$template_size} &blacksquare; {$template_download}";
		$template = apply_filters('get_podcast_meta_template', $template);

		return $this->wrap($template, 'episode-download-meta', 'div');

	}

	public function get_hero_albumart() {
		$image = $this->episode->get_albumart();

		if ( $image )
			$template = "<a href=\"{$this->episode->get_permalink()}\"><img src=\"{$image['url']}\" class=\"{$image['class']}\" /></a>";
		else
			$template = "<div><!-- --></div>";
		
		return $this->wrap($template, 'episode-albumart', 'div');
	}

	public function get_showboard_albumart() {
		$image = $this->episode->get_albumart(array('size' => 'thumbnail'));

		if ( $image )
			$template = "<a href=\"{$this->episode->get_permalink()}\"><img src=\"{$image['url']}\" class=\"{$image['class']}\" /></a>";
		else
			$template = "<div><!-- --></div>";
		
		return $this->wrap($template, 'episode-albumart', 'div');
	}

	public function get_series_list_albumart() {
		$image = $this->episode->get_albumart(array('size' => 'thumbnail'));

		$url = $this->episode->get_series()->get_permalink();
		if ( empty($url) ) $url = $this->episode->get_permalink();

		if ( $image )
			$template = "<a href=\"{$url}\"><img src=\"{$image['url']}\" class=\"{$image['class']}\" /></a>";
		else
			$template = "<div><!-- --></div>";
		
		return $this->wrap($template, 'episode-albumart', 'div');
	}

	// villain needs raw urls
	public function get_villain_albumart() {
		$image = $this->episode->get_albumart(array('size' => 'large'));
		return $image['url'];
	}

}
