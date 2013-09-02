<?php


class Coprime_Person {

	private $person;

	public function __construct(Nexus_Person $person) {
		$this->person = $person;
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

	public function get_name() {
		return $this->person->get_name();
	}

	public function get_formatted_name($tag = 'div') {
		$template = "<a href=\"{$this->person->get_permalink()}\">{$this->person->get_name()}</a>";
		return $this->wrap($template, 'name', $tag);
	}

	public function get_avatar($size = 100) {
		$email = $this->person->get_email();
		if (!$email) $email = '';
		$gravatar = get_avatar($email, $size);
		$template = "<a href=\"{$this->person->get_permalink()}\">{$gravatar}</a>";
		return $this->wrap($template, 'avatar-image', 'div');
	}

	public function get_content() {
		$content = $this->person->get_content();
		return $this->wrap($content, 'person-content', 'div');
	}

	public function get_short_content($length = 140) {
		$content = $this->person->get_content();
		$text = strip_tags($content);

		if ( strlen($text) > $length ) {
			$text = substr($text, 139);
			$text = '...';
		}

		return $this->wrap($text, 'person-content', 'p');
	}

	public function get_links() {
		$links = array();
		$links['Twitter'] = $this->person->get_twitter_url();
		$links['Google+'] = $this->person->get_googleplus_url();
		$links['Website'] = $this->person->get_website_url();

		$content = '';
		foreach ($links as $key => $value) {
			if ( !$value ) continue;
			$template = "<a href=\"{$value}\">{$key}</a>";
			$content = $content . $this->wrap($template, 'person-link', 'li'); 
		}

		return $this->wrap($content, 'person-links', 'ul');

	}


}
