<?php

namespace Tests\Runroom\BaseBundle\Unit;

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

        $this->assertSame($expected_metas, $metas);
    }

    /**
     * @test
     */
    public function itSetContent()
    {
        $expected_content = 'content';

        $this->view_model->setContent($expected_content);

        $content = $this->view_model->getContent();

        $this->assertSame($expected_content, $content);
    }

    /**
     * @test
     */
    public function itSetAlternateLinks()
    {
        $expected_alternate = 'alternate_links';

        $this->view_model->setAlternateLinks($expected_alternate);

        $alternate_links = $this->view_model->getAlternateLinks();

        $this->assertSame($expected_alternate, $alternate_links);
    }
}
