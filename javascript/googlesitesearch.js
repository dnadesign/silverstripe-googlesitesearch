;(function($) {
	// Simple JavaScript Templating
	// John Resig - http://ejohn.org/ - MIT Licensed
	(function(){
	  var cache = {};
	 
	  this.tmpl = function tmpl(str, data){
	    // Figure out if we're getting a template, or if we need to
	    // load the template - and be sure to cache the result.
	    var fn = !/\W/.test(str) ?
	      cache[str] = cache[str] ||
	        tmpl(document.getElementById(str).innerHTML) :
	     
	      // Generate a reusable function that will serve as a template
	      // generator (and which will be cached).
	      new Function("obj",
	        "var p=[],print=function(){p.push.apply(p,arguments);};" +
	       
	        // Introduce the data as local variables using with(){}
	        "with(obj){p.push('" +
	       
	        // Convert the template into pure JavaScript
	        str
	          .replace(/[\r\t\n]/g, " ")
	          .split("{{").join("\t")
	          .replace(/((^|}})[^\t]*)'/g, "$1\r")
	          .replace(/\t=(.*?)}}/g, "',$1,'")
	          .split("\t").join("');")
	          .split("}}").join("p.push('")
	          .split("\r").join("\\'")
	      + "');}return p.join('');");
	   
	    // Provide some basic currying to the user
	    return data ? fn( data ) : fn;
	  };
	})();

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
				var qs = new Uri(q),
					key = search.data('key'),
					cx = search.data('cx'),
					domain = search.data('domain'),
					start = qs.getQueryParamValue('start') || 1;

				if(qs.getQueryParamValue('Search')) {
					var url = "https://www.googleapis.com/customsearch/v1?key="+ key +"&cx="+ cx +"&siteSearch="+ domain +"&safe=high&q="+ qs.getQueryParamValue('Search') +"&start="+ start +"&callback=?";

					$.support.cors = true;
					$.ajaxSetup({ cache: false });

					$.getJSON(url, function(data) {
						if(!data) {
							return search_error();
						}

						var list = $(".result_list", results);

						if(typeof data.items !== "undefined" && data.items.length > 0) {
							// if there is a next page, create a link for the next page.
							if(typeof data.queries.nextPage !== "undefined" && data.queries.nextPage.length > 0) {
								qs.replaceQueryParam('start', data.queries.nextPage[0].startIndex);

								data.nextLink = qs.toString();
							}

							// if there is a previous page, create a link for the previous page
							if(typeof data.queries.previousPage !== "undefined" && data.queries.previousPage.length > 0) {
								qs.replaceQueryParam('start', data.queries.previousPage[0].startIndex);

								data.previousLink = qs.toString();
							}

							results.removeClass('results_loading')
							results.before(tmpl("pre_result_tmpl", data));

							$.each(data.items, function(i, obj) {
								list.append(tmpl("result_tmpl", obj));
							});

							results.after(tmpl("post_result_tmpl", data));
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
})(jQuery);