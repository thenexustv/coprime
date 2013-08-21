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
		$template = "<a href=\"{$this->episode->get_permalink()}\">{$this->episode->get_title()}</a>";
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
		$diff = Nexus_Core::human_time_difference( $this->episode->get_posted_date('U'), current_time('timestamp') ) ;
		$date = $this->episode->get_posted_date('F jS Y');
		$raw = $this->episode->get_posted_date('r');
		$ago = "$diff ago";

		$template = "<time datetime=\"{$raw}\">{$date} &blacksquare; {$ago}</time>";
		return $this->wrap($template, 'episode-date');
	}

	public function get_episode_description() {
		$description = apply_filters('get_episode_description', $this->episode->get_excerpt());
		return $this->wrap($description, 'episode-description', 'div');
	}

	public function get_podcast_player() {

		$enclosure = $this->episode->get_enclosure();
		$file = $enclosure['url'];
		$shortcode = "[audio mp3=\"$file\"]";

		return do_shortcode( $shortcode );

	}


}
