<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RandomController extends AbstractController
{
    #[Route('/random', name: 'random')]
    public function __invoke(): Response
    {
        return $this->render('random.html.twig', [
            'random' => random_int(0, 100),
        ]);
    }
}
