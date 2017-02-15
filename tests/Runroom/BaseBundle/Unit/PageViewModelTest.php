<?php

namespace Tests\Runroom\BaseBundle\Unit;

use PHPUnit\Framework\TestCase;
use Runroom\BaseBundle\ViewModel\PageViewModel;

class PageViewModelTest extends TestCase
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
        $this->view_model->setMetas('metas');

        $metas = $this->view_model->getMetas();

        $this->assertSame('metas', $metas);
    }

    /**
     * @test
     */
    public function itSetContent()
    {
        $this->view_model->setContent('content');

        $content = $this->view_model->getContent();

        $this->assertSame('content', $content);
    }

    /**
     * @test
     */
    public function itSetAlternateLinks()
    {
        $this->view_model->setAlternateLinks('alternate_links');

        $alternate_links = $this->view_model->getAlternateLinks();

        $this->assertSame('alternate_links', $alternate_links);
    }
}
