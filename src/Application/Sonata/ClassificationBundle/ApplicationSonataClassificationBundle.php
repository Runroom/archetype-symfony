<?php

namespace Application\Sonata\ClassificationBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ApplicationSonataClassificationBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'SonataClassificationBundle';
    }
}
