<?php

namespace Archetype\DemoBundle\ViewModel;

use Runroom\FormHandlerBundle\ViewModel\FormAware;
use Runroom\FormHandlerBundle\ViewModel\FormAwareInterface;

class AjaxFormViewModel implements FormAwareInterface
{
    use FormAware;
}
