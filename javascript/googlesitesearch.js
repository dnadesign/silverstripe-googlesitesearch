;(function() {

	function Querystring(qs) { // optionally pass a querystring to parse
		this.params = {};

		if (qs == null) qs = location.search.substring(1, location.search.length);
		if (qs.length == 0) return;

	// Turn <plus> back to <space>
	// See: http://www.w3.org/TR/REC-html40/interact/forms.html#h-17.13.4.1
		qs = qs.replace(/\+/g, ' ');
		var args = qs.split('&'); // parse out name/value pairs separated via &

	// split out each name=value pair
		for (var i = 0; i < args.length; i++) {
			var pair = args[i].split('=');
			var name = decodeURIComponent(pair[0]);

			var value = (pair.length==2)
				? decodeURIComponent(pair[1])
				: name;

			this.params[name] = value;
		}
	}

	Querystring.prototype.get = function(key, default_) {
		var value = this.params[key];
		return (value != null) ? value : default_;
	}

	Querystring.prototype.contains = function(key) {
		var value = this.params[key];
		return (value != null);
	}


	function loadjQuery(url, callback) {
		var script_tag = document.createElement('script');
		script_tag.setAttribute("src", url)
		script_tag.onload = callback; // Run callback once jQuery has loaded
		
		script_tag.onreadystatechange = function () { // Same thing but for IE
			if (this.readyState == 'complete' || this.readyState == 'loaded') callback();
		}
	
		script_tag.onerror = function() {
			loadjQuery("framework/thirdparty/jquery/jquery.min.js", main);
		}
	
		document.getElementsByTagName("head")[0].appendChild(script_tag);
	}

	if (typeof jQuery === "undefined") {
		loadjQuery("//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js", verifyJQueryCdnLoaded);
	} else {
		main();
	}

	function verifyJQueryCdnLoaded() {
		if (typeof jQuery === "undefined") {
			loadjQuery("framework/thirdparty/jquery/jquery.min.js", main);
		}
		else {
			main();
		}
	}

	function main() {
		$(document).ready(function () {
			var search = $("#g_cse"),
				results = $("#g_cse_results"),
				header = $("#g_cse_results_header");

			function search_error() {
				results.removeClass('results_loading');
				results.addClass('results_haserror');
			}

			function search_noresults() {
				results.removeClass('results_loading');
				results.addClass('results_hasnoresults');
			}

			if(search.length > 0) {
				var q = window.location.href;

				if(/\?Search=/.test(q)) {
					var qs = new Querystring(q.substring(q.indexOf("?") + 1)),
						key = search.data('key'),
						cx = search.data('cx'),
						domain = search.data('domain');

					if(qs.get('Search')) {
						var url = "https://www.googleapis.com/customsearch/v1?key="+ key +"&cx="+ cx +"&siteSearch="+ domain +"&safe=high&q="+ qs.get('Search') +"&num=20&callback=?";

						$.support.cors = true;
						$.ajaxSetup({ cache: false });

						$.getJSON(url, function(data) {
							if(!data) {
								return search_error();
							}

							var list = $(".result_list", results);

							if(typeof data.items !== "undefined" && data.items.length > 0) {
								results.removeClass('results_loading')

								$.each(data.items, function(i, obj) {
									var heading = $("<h4></h4>").html(
										$("<a></a>").attr('href', obj.link).text(obj.title)
									);

									var content = $("<p></p>").text(obj.snippet);
									content.before();

									result = $("<li></li>")	
										.append(heading)
										.append($("<p class='result_link'></p>").html(obj.htmlFormattedUrl))
										.append(content);

									list.append(result);
								});
							}
							else {
								search_noresults();
							}
						});
					}
					else {
						search_error();
					}
				}
			}
		});
	}
})();