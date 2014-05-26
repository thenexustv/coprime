<?php
	if ( !is_singular() ):
		loop_pagination(array('mid_size' => 3, 'end_size' => 2));
	endif;
?><!-- paginate -->