<?php

namespace DNADesign\GoogleSiteSearch\Pages;

use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\View\Requirements;

/**
 * @package googlesitesearch
 */
class GoogleSiteSearchPageController extends \PageController
{
    /**
     *
     */
    public function init()
    {
        parent::init();

        Requirements::javascript('silverstripe/admin: thirdparty/jquery/jquery.js');
        Requirements::javascript('dnadesign/silverstripe-googlesitesearch: javascript/uri.js');
        Requirements::javascript('dnadesign/silverstripe-googlesitesearch: javascript/googlesitesearch.js');

        Requirements::css('dnadesign/silverstripe-googlesitesearch: css/googlesitesearch.css');

        if (isset($_GET['Search'])) {
            $sanitized_search_text = filter_var($_GET['Search'], FILTER_SANITIZE_STRING);
            $this->GoogleSiteSearchText = DBField::create_field(
                'HTMLText',
                $sanitized_search_text
            );
        }
    }
}
