<?php

namespace Runroom\BaseBundle\Tests\Unit;

use Runroom\BaseBundle\ViewModel\PageViewModel;

class PageViewModelTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->view_model = new PageViewModel();
    }

    /**
     * @test
     */
    public function itSetMetas()
    {
        $expected_metas = 'metas';

        $this->view_model->setMetas($expected_metas);

        $metas = $this->view_model->getMetas();

        $this->assertEquals($expected_metas, $metas);
    }

    /**
     * @test
     */
    public function itSetContent()
    {
        $expected_content = 'content';

        $this->view_model->setContent($expected_content);

        $content = $this->view_model->getContent();

        $this->assertEquals($expected_content, $content);
    }

    /**
     * @test
     */
    public function itSetAlternateLinks()
    {
        $expected_alternate_links = 'alternate_links';

        $this->view_model->setAlternateLinks($expected_alternate_links);

        $alternate_links = $this->view_model->getAlternateLinks();

        $this->assertEquals($expected_alternate_links, $alternate_links);
    }

    /**
     * @test
     */
    public function itSetFooterStaticPages()
    {
        $expected_footer_static_pages = 'footer_static_pages';

        $this->view_model->setFooterStaticPages($expected_footer_static_pages);

        $footer_static_pages = $this->view_model->getFooterStaticPages();

        $this->assertEquals($expected_footer_static_pages, $footer_static_pages);
    }
}
