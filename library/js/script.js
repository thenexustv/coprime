(function ($) {

	function mejs_rails_fix() {
		// find all the rails, likely to be only one
		var rails = $(document).find('.mejs-time-rail');
		rails.width( rails.width() - 1 );
	}

	function mejs_attach_click() {
		$('.mejs-play button').click(function(event){

			setTimeout(function(){

				mejs_rails_fix();

			}, 1500);

		});
	}

	function setup_mejs_rails_fix() {

		setTimeout(function(){

			mejs_attach_click();

		}, 250);

		setTimeout(function(){

			mejs_rails_fix();
			mejs_rails_fix();
			mejs_rails_fix();
			console.log("initial");
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

		setTimeout(idle_nexus, 1000 * 60 * 2.43);

	}

	function setup_reveal_share() {

		var element = $('.share');
		var header = $(element).find('h4');
		var container = element.find('.container')
		
		header.html('Load Sharing &rarr;');
		header.addClass('clickable');
		container.hide();

		header.on('touchstart click', function(event) {
			container.show('slow');
			header.html('Sharing');
			header.removeClass('clickable');
			element.addClass('opened');
			event.preventDefault();

		});

	}

	function setup_shownote_clicks() {

		var elements = $('.single-episode .content-section ul li a');
		elements.attr('target', '_blank');

	}

	$(document).ready(function(){

		setup_mejs_rails_fix();
		setup_idle_nexus();
		setup_reveal_share();
		setup_shownote_clicks();

	});



}(jQuery));