<?php

/**
 * @package googlesitesearch
 */
class GoogleSiteSearchDefaultFormExtension extends DataExtension {
	
	/**
	 * Return a form which sends the user to the first results page. If you want
	 * to customize this form, use your own extension and apply that to the
	 * page.
	 *
	 * @return Form
	 */
	public function getGoogleSiteSearchForm() {
		if($page = GoogleSiteSearchPage::get()->first()) {
			$form = new Form(
				$this, 
				'GoogleSiteSearchForm', 
				new FieldList(new TextField('Search')),
				new FieldList(new FormAction('doSearch'))
			);

			$form->setFormMethod('GET');
			$form->setFormAction($page->Link());
			$form->disableSecurityToken();
			$form->loadDataFrom($_GET);
			
			return $form;
		}
	}
}