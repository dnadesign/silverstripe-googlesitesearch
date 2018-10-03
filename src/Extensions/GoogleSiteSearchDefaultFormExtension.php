<?php

namespace DNADesign\GoogleSiteSearch\Extensions;

use DNADesign\GoogleSiteSearch\Pages\GoogleSiteSearchPage;
use SilverStripe\Control\Controller;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Config\Configurable;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\TextField;

/**
 * @package googlesitesearch
 */
class GoogleSiteSearchDefaultFormExtension extends Extension
{
    use Configurable;

    /**
     * @var array
     */
    private static $allowed_actions = [
        'GoogleSiteSearchForm',
    ];

    /**
     * Return a form which sends the user to the first results page. If you want
     * to customize this form, use your own extension and apply that to the
     * page.
     *
     * @return Form
     */
    public function GoogleSiteSearchForm()
    {
        if ($page = GoogleSiteSearchPage::get()->first()) {
            $label = $this->owner->config()->get('submit_button_label');
            $formLabel = $this->owner->config()->get('input_label');

            $form = new Form(
                Controller::curr(),
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
