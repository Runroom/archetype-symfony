<?php

namespace Application\Sonata\MediaBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ApplicationSonataMediaBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'SonataMediaBundle';
    }
}
