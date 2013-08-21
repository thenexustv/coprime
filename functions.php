<?php

require_once('library/class-coprime.php');
require_once('library/class-coprime-episode.php');
require_once('library/class-coprime-series.php');



add_action('after_setup_theme', array('Coprime', 'get_instance'), 16);