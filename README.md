# Google Site Search Module

## Maintainer Contact

* Will Rossiter (Nickname: wrossiter, willr) <will.rossiter@dna.co.nz>

## Requirements

* SilverStripe 3.1

## Documentation

Adds the ability for a user to search the site through Google Site Search. This
is done via a new Page in the CMS (GoogleSiteSearchPage) and results are fetched
from Google via ajax. The search form and results are free to style via CSS. 

1) Sign up for www.google.com/sitesearch
2) Install this module to your site root folder named `googlesitesearch`
3) Rebuild your database using `dev/build`
4) Enter your Google CSE CX and key values in the CMS under a new instance of 
the newly added GoogleSiteSearchPage or through the config flag 
`GoogleSiteSearchPage.cse_key` and `GoogleSiteSearchPage.cse_key` respectively.

5) Add the default search form to your controller (or use your own extension
for styling / changing the form). In mysite/_config/googlesitesearch.yml add
the following:

	Controller:
  	  extensions:
      - GoogleSiteSearchDefaultFormExtension

6) Add a search form to your `Page.ss` template $GoogleSiteSearchForm

Ensure you read the Google Custom Search Terms before installing the module and
agree to the terms and conditions https://www.google.co.nz/cse/docs/tos.html

	
