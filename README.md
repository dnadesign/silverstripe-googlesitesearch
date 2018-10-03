# Google Site Search Module

## Requirements

* SilverStripe 4

## Documentation

Adds the ability for a user to search the site through Google Site Search. This
is done via a new Page in the CMS (GoogleSiteSearchPage) and results are fetched
from Google via ajax. The search form and results are free to style via CSS. 

1) Sign up for www.google.com/sitesearch
2) Install this module to your site root folder named `googlesitesearch`
3) Rebuild your database using `dev/build`
4) Enter your Google CSE CX and key values in the CMS under a new instance of 
the newly added GoogleSiteSearchPage or through the config flag 
`GoogleSiteSearchPage.cse_key` and `GoogleSiteSearchPage.cse_cx` respectively.

5) Add the default search form to your controller (or use your own extension
for styling / changing the form). In mysite/_config/googlesitesearch.yml add
the following:

	Controller:
  	  extensions:
      - GoogleSiteSearchDefaultFormExtension

6) Add a search form to your `Page.ss` template $GoogleSiteSearchForm

Ensure you read the Google Custom Search Terms before installing the module and
agree to the terms and conditions https://www.google.co.nz/cse/docs/tos.html

## Customization

Full HTML control is available by providing a custom `GoogleSiteSearchPage`
template on the page. Since the results are loaded via AJAX, [John Resig's Micro Templating](http://ejohn.org/blog/javascript-micro-templating/)
is used to provide basic utility templates in results, header and footer 
templates.

Out of the box a basic header message and pagination in the footer is provided
but you are free to alter the page as you need to. More documentation on the
available data to output to the template (such as file information) is at
[developers.google.com/custom-search/v1/using_rest](https://developers.google.com/custom-search/v1/using_rest)
