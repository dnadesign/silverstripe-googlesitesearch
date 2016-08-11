<?php

/**
 * @package googlesitesearch
 */
class GoogleSiteSearchPage extends Page {

	public static $db = array(
		'GoogleKey' => 'Varchar(200)',
		'GoogleCX' => 'Varchar(200)',
		'GoogleDomain' => 'Varchar(255)'
	);

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->addFieldsToTab('Root.Main', array(
			new TextField('GoogleKey', 'Google Custom Search Key (sign up at <a href="https://www.google.com/cse/sitesearch/create" target="_blank">google.com/cse</a>)'),
			new TextField('GoogleCX', 'Google Custom Search CX'),
			new TextField('GoogleDomain', 'Domain to search results for (must be public, i.e use live URL for testing)')
		));

		return $fields;
	}

	public function requireDefaultRecords() {
		if($this->config()->get('create_default_search_page')) {
			if(GoogleSiteSearchPage::get()->count() < 1) {
				$search = new GoogleSiteSearchPage();
				$search->Title = "Search results";
				$search->MenuTitle = "Search";
				$search->ShowInMenus = 0;
				$search->ShowInSearch = 0;
				$search->GoogleKey = $this->config()->get('cse_key');
				$search->GoogleCX = $this->config()->get('cse_cx');
				$search->URLSegment = "search";
				$search->write();

				$search->doPublish('Stage', 'Live');
			}
		}
	}

	public function MetaTags($includeTitle = true) {
		$tags = parent::MetaTags($includeTitle);
		$tags.= '<meta name="robots" content="noindex">';
		return $tags;
	}

	/**
	 * @return string
	 */
	public function getCseKey() {
		if($this->GoogleKey) return $this->GoogleKey;

		return $this->config()->get('cse_key');
	}

	/**
	 * @return string
	 */
	public function getCseCx() {
		if($this->GoogleKey) return $this->GoogleCX;

		return $this->config()->get('cse_cx');
	}
}

/**
 * @package googlesitesearch
 */
class GoogleSiteSearchPage_Controller extends Page_Controller {

	public function init() {
		parent::init();

		Requirements::javascript(THIRDPARTY_DIR . '/jquery/jquery.js');
		Requirements::javascript('googlesitesearch/javascript/uri.js');
		Requirements::javascript('googlesitesearch/javascript/googlesitesearch.js');

		Requirements::css('googlesitesearch/css/googlesitesearch.css');

		if(isset($_GET['Search'])) {
            $sanitized_search_text = filter_var($_GET['Search'], FILTER_SANITIZE_STRING);
			$this->GoogleSiteSearchText = DBField::create_field(
				'HTMLText',
				$sanitized_search_text
			);
		}
	}
}
