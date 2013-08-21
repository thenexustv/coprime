(function ($) {

	function mejs_rails_fix() {
		// find all the rails, likely to be only one
		var rails = $(document).find('.mejs-time-rail');
		rails.width( rails.width() - 1 );
		console.log( rails.width() );
	}
	function mejs_rails_fix_setup() {

		setTimeout(function(){

			mejs_rails_fix();

		}, 100);

		$(window).resize(function(){
			setTimeout(mejs_rails_fix, 110);
		});

	}

	$(document).ready(function(){

		mejs_rails_fix_setup();

	});



}(jQuery));