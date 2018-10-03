<?php

namespace DNADesign\GoogleSiteSearch\Pages;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Versioned\Versioned;

/**
 * @package googlesitesearch
 */
class GoogleSiteSearchPage extends \Page
{
    /**
     * @var array
     */
    private static $db = [
        'GoogleKey' => 'Varchar(200)',
        'GoogleCX' => 'Varchar(200)',
        'GoogleDomain' => 'Varchar(255)',
    ];

    /**
     * @var string
     */
    private static $table_name = 'GoogleSiteSearchPage';

    /**
     * @return \SilverStripe\Forms\FieldList
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->addFieldsToTab('Root.Main', [
                TextField::create('GoogleKey')
                    ->setTitle('Google Custom Search Key (sign up at <a href="https://www.google.com/cse/sitesearch/create" target="_blank">google.com/cse</a>)'),
                TextField::create('GoogleCX')
                    ->setTitle('Google Custom Search CX'),
                TextField::create('GoogleDomain')
                    ->setTitle('Domain to search results for (must be public, i.e use live URL for testing)'),
            ]);
        });

        return parent::getCMSFields();
    }

    /**
     * @throws \SilverStripe\ORM\ValidationException
     */
    public function requireDefaultRecords()
    {
        if ($this->config()->get('create_default_search_page')) {
            if (GoogleSiteSearchPage::get()->count() < 1) {
                $search = GoogleSiteSearchPage::create();
                $search->Title = "Search results";
                $search->MenuTitle = "Search";
                $search->ShowInMenus = 0;
                $search->ShowInSearch = 0;
                $search->GoogleKey = $this->config()->get('cse_key');
                $search->GoogleCX = $this->config()->get('cse_cx');
                $search->URLSegment = "search";
                $search->write();
                $search->writeToStage(Versioned::DRAFT);
                $search->publishRecursive();
            }
        }
    }

    /**
     * @param bool $includeTitle
     * @return string
     */
    public function MetaTags($includeTitle = true)
    {
        $tags = parent::MetaTags($includeTitle);
        $tags .= '<meta name="robots" content="noindex">';
        return $tags;
    }

    /**
     * @return string
     */
    public function getCseKey()
    {
        if ($this->GoogleKey) return $this->GoogleKey;

        return $this->config()->get('cse_key');
    }

    /**
     * @return string
     */
    public function getCseCx()
    {
        if ($this->GoogleKey) return $this->GoogleCX;

        return $this->config()->get('cse_cx');
    }
}
