(function ($) {

	function mejs_rails_fix() {
		// find all the rails, likely to be only one
		var rails = $(document).find('.mejs-time-rail');
		rails.width( rails.width() - 1 );
		console.log( rails.width() );
	}

	function mejs_attach_click() {
		$('.mejs-play button').click(function(event){

			setTimeout(function(){

				mejs_rails_fix();

			}, 1500);

		});
	}

	function mejs_rails_fix_setup() {

		setTimeout(function(){

			mejs_attach_click();

		}, 250);

		setTimeout(function(){

			mejs_rails_fix();

		}, 100);

		$(window).resize(function(){
			setTimeout(mejs_rails_fix, 110);
		});

	}

	function idle_nexus() {
		var element = $('.nexus-title');
		element.addClass('idle');
	}

	function setup_idle_nexus() {

		setTimeout(idle_nexus, 1000 * 60 * 5);

	}

	function setup_reveal_share() {

		var element = $('.share');
		element.hide();

		setTimeout(function(){

			element.show('slow');

		}, 1000 * 10);

	}

	function setup_shownote_clicks() {

		var elements = $('.single-episode .content-section ul li a');
		elements.attr('target', '_blank');

	}

	$(document).ready(function(){

		mejs_rails_fix_setup();
		setup_idle_nexus();
		setup_reveal_share();
		setup_shownote_clicks();

	});



}(jQuery));