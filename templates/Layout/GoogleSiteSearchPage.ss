<div id="g_cse" data-key="$CseKey" data-cx="$CseCx" data-domain="$GoogleDomain">
	<div class="g_cse_results_header">
		<h1>$Title / <strong>$GoogleSiteSearchText</strong></h1>
	</div>

	<div id="g_cse_results" class="results_loading">
		<ul class="result_list"></ul>

		<div class="result_error">
			<h4>Sorry could not connect to search server. Please try again.</h4>
		</div>

		<div class="result_empty">
			<h4>No results matching that query found. Try another search keyword.</h4>
		</div>

		<div class="result_nosearchterm">
			<h4>Enter a search term to see results.</h4>
		</div>
	</div>
</div>

<!-- formatting for each search result. Scope is set to each result (item). See https://developers.google.com/custom-search/v1/using_rest -->
<script type="text/html" id="result_tmpl">
	<li>
		<h4><a href="{{=link}}">{{=title}}</a></h4>
		<p class="result_meta"><a href="{{=link}}">{{=htmlFormattedUrl}}</a></p>
		<p>{{=htmlSnippet}}</p>
	</li>
</script>

<!-- The pre result template is rendered before the result_list if results exist. Scope is the entire response -->
<script type="text/html" id="pre_result_tmpl">
	<p class="results_showing">Showing results {{=queries.request[0].startIndex}} - {{=(true) ? queries.request[0].count + (queries.request[0].startIndex - 1) : "" }} of {{=queries.request[0].totalResults}} results.</p>
</script>

<!-- The post result template is rendered after the result_list if results exist. Scope is the entire response -->
<script type="text/html" id="post_result_tmpl">
	{{ if(typeof previousLink !== "undefined") }}
		<div class="results_pagination"><p class="results_previous"><a href="{{=previousLink}}">Previous Page</a></p></div>
	{{ if(typeof nextLink !== "undefined") }}
		<div class="results_pagination"><p class="results_next"><a href="{{=nextLink}}">Next Page</a></p> </div>
</script>
