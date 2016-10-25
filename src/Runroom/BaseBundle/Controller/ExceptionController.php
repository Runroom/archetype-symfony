<?php

namespace Runroom\BaseBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

class ExceptionController extends BaseController
{
    const NOT_FOUND = 'pages/404.html.twig';

    public function notFound()
    {
        return $this->renderResponse(self::NOT_FOUND, null, new Response('', 404));
    }
}
