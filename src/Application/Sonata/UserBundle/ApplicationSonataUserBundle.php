<?php

namespace Application\Sonata\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ApplicationSonataUserBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getParent(): string
    {
        return 'SonataUserBundle';
    }
}
