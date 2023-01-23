<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class StorybookController extends AbstractController
{
    #[Route('/_storybook/{component}', name: 'storybook_component')]
    public function index(Request $request, string $component)
    {
        return $this->render('storybook/render_component.html.twig', [
            'name' => $component,
            'props' => $request->query->all(),
        ]);
    }
}
