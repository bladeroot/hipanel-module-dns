<?php

namespace hipanel\modules\dns\tests\acceptance\client;

use hipanel\helpers\Url;
use hipanel\tests\_support\Page\IndexPage;
use hipanel\tests\_support\Step\Acceptance\Client;

class DnsCest
{
    /**
     * @var IndexPage
     */
    private $index;

    public function _before(Client $I)
    {
        $this->index = new IndexPage($I);
    }

    public function ensureIndexPageWorks(Client $I)
    {
        $I->login();
        $I->needPage(Url::to('@dns/zone'));
        $I->see('DNS zones', 'h1');
        $this->ensureICanSeeAdvancedSearchBox($I);
        $this->ensureICanSeeBulkSearchBox();
    }

    private function ensureICanSeeAdvancedSearchBox(Client $I)
    {
        $I->see('Advanced search', 'h3');

        $formId = 'form-advancedsearch-zone-search';
        $this->index->containsFilters($formId, [
            ['input' => [
                'id' => 'zonesearch-idn_like',
                'placeholder' => 'Domain',
            ]],
        ]);

        $I->see('Server', "//form[@id='$formId']//span");
        $I->see('Account', "//form[@id='$formId']//span");
    }

    private function ensureICanSeeBulkSearchBox()
    {
        $this->index->containsBulkButtons([
            ["//button[@type='submit']" => 'Export DNS records'],
        ]);
        $this->index->containsColumns('bulk-zone-search', [
            'Domain',
            'NS servers',
            'DNS',
            'Bound to',
        ]);
    }
}
