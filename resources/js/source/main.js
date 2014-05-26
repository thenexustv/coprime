(function ($) {

	/*
		jQuery query string parser.
		https://gist.github.com/kares/956897
	*/
	(function($) {
	    var re = /([^&=]+)=?([^&]*)/g;
	    var decode = function(str) {
	        return decodeURIComponent(str.replace(/\+/g, ' '));
	    };
	    $.parseParams = function(query) {
	        var params = {}, e;
	        if (query) {
	            if (query.substr(0, 1) == '?') {
	                query = query.substr(1);
	            }

	            while (e = re.exec(query)) {
	                var k = decode(e[1]);
	                var v = decode(e[2]);
	                if (params[k] !== undefined) {
	                    if (!$.isArray(params[k])) {
	                        params[k] = [params[k]];
	                    }
	                    params[k].push(v);
	                } else {
	                    params[k] = v;
	                }
	            }
	        }
	        return params;
	    };
	})($);

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
		}, 100);

		$(window).resize(function(){
			setTimeout(mejs_rails_fix, 110);
		});

	}

	function idle_nexus() {
		var header = $('.nexus-title');
		// var footer = $('.nx-end span');
		header.addClass('idle');
		// footer.addClass('idle');
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

	function human_time_difference(from, to) {
		to = to || Date.now();

		// convert MS to S
		to = to / 1000;
		from = from / 1000;

		var periods = {
			'minutes' : ['%s minute', '%s minutes'],
			'hours' : ['%s hour', '%s hours'],
			'days' : ['%s day', '%s days'],
			'weeks' : ['%s week', '%s weeks'],
			'months' : ['%s month', '%s months'],
			'years' : ['%s year', '%s years']
		};

		var ranges = {
			'years' : 31556926,
			'months' : 2592000,
			'weeks' : 604800,
			'days' : 86400,
			'hours' : 3600,
			'minutes' : 60
		};

		var diff = Math.abs(to - from);
		var since = '';

		$.each(ranges, function(key, value){
			if ( diff <= value ) return; // jquery continue

			var time = Math.round(diff / value);
			if (time < 1) {
				time = 1;
			}

			since = (time == 1 ? periods[key][0] : periods[key][1]).replace('%s', time);
			return false; // jquery break

		});



		return since;

	}

	function setup_human_date_time() {

		$('time span.ago').each(function(index, element){
			var time = $(element).parent('time');
			var raw = time.attr('datetime');
			var diff = human_time_difference( Date.parse(raw) );
			$(element).html(diff + " ago");
		});

	}

	// http://stackoverflow.com/questions/1053902/how-to-convert-a-title-to-a-url-slug-in-jquery
	function to_slug(text) {
		return text.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
	}

	function setup_contact_listener() {

		var elements = $('.wpcf7');

		elements.each(function(index, element){

			var topic = $(element).find('.your-recipient');
			var body = $(element).find('.your-message textarea');

			if ( $.isEmptyObject(topic) || $.isEmptyObject(body) ) return false;

			var query = window.location.search;
			var obj = $.parseParams(query);
			
			if ( !obj.show || !obj.number ) return false;

			var show = null;
			topic.find('option').each(function(i, el){
				el = $(el);
				if ( to_slug(el.val()) == obj.show ) {
					el.attr('selected', 'selected');
					show = el;
					return false;
				}
			});

			var string = "With regards to " + show.val() + " Episode #" + obj.number + ",\n\n";
			
			body.val(string);


		});

	}

	$(document).ready(function(){

		// setup_mejs_rails_fix();
		setup_idle_nexus();
		setup_reveal_share();
		setup_shownote_clicks();
		setup_human_date_time();
		setup_contact_listener();

	});



}(jQuery));