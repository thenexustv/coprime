<?php


class Coprime_Series {

	private $series;

	public function __construct(Nexus_Series $series) {
		$this->series = $series;
	}

	private function classes_array_to_string($array = array()) {
		if ( is_string($array) ) $array = array($array);
		$string = trim(join(' ', $array));
		return $string;
	}

	private function wrap($content, $classes = array(), $tag = 'span') {
		if ( $content == '' ) return '';
		$class_string = $this->classes_array_to_string($classes);
		return "<{$tag} class=\"{$class_string}\">$content</{$tag}>";
	}

	public function get_series_description() {
		$description = apply_filters('get_series_description', $this->series->get_description());

		$sizes = apply_filters('series_description_sizes', array( 'long' => 350, 'medium' => 200));
		$classes = array('series-description');
		$add = 'short';
		foreach ($sizes as $name => $value) {
			if ( strlen($description) > $value ) {
				$add = $name;
				break;
			}
		}
		$classes[] = $add;

		return $this->wrap($description, $classes, 'p');
	}

	public function get_series_name() {
		$name = apply_filters('get_series_name', $this->series->get_name());
		$template = "<a href=\"{$this->series->get_permalink()}\">{$name}</a>";
		return $this->wrap($template, 'series-name');
	}

	public function get_series_subscriptions() {
		$name = $this->series->get_name();
		$feed = $this->series->get_feed_permalink();

		$template = "<a href=\"{$feed}\">{$name}</a>";
		$output = $this->wrap($template, 'regular', 'li');

		if ( 'tf' != $this->series->get_slug() ) {
			$template = "<a href=\"{$feed}?fringe\">{$name} &amp; The Fringe</a>";
			$output = $output . $this->wrap($template, 'with-fringe', 'li');
		}

		return $this->wrap($output, 'series-subscriptions', 'ul');
	}

}
