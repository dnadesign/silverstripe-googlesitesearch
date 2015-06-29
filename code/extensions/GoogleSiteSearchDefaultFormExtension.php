<?php

/**
 * @package googlesitesearch
 */
class GoogleSiteSearchDefaultFormExtension extends DataExtension {
	
	private static $submit_button_label = 'Go';
	
	private static $input_label = 'Search';
	
	/**
	 * Return a form which sends the user to the first results page. If you want
	 * to customize this form, use your own extension and apply that to the
	 * page.
	 *
	 * @return Form
	 */
	public function getGoogleSiteSearchForm() {
		if($page = GoogleSiteSearchPage::get()->first()) {
			$label = Config::inst()->get('GoogleSiteSearchDefaultFormExtension', 'submit_button_label');
			$formLabel = Config::inst()->get('GoogleSiteSearchDefaultFormExtension', 'input_label');
			
			$form = new Form(
				$this, 
				'GoogleSiteSearchForm', 
				new FieldList(new TextField('Search', $formLabel)),
				new FieldList(new FormAction('doSearch', $label))
			);

			$form->setFormMethod('GET');
			$form->setFormAction($page->Link());
			$form->disableSecurityToken();
			$form->loadDataFrom($_GET);
			
			return $form;
		}
	}
}
