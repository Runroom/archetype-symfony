<?php

declare(strict_types=1);

namespace App\Action;

use App\Service\PositionHandlerInterface;
use Sonata\AdminBundle\Request\AdminFetcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\Translation\TranslatorInterface;

final class MoveTreeAction extends AbstractController
{
    private TranslatorInterface $translator;
    private AdminFetcherInterface $adminFetcher;
    private PositionHandlerInterface $positionHandler;

    public function __construct(
        TranslatorInterface $translator,
        AdminFetcherInterface $adminFetcher,
        PositionHandlerInterface $positionHandler
    ) {
        $this->translator = $translator;
        $this->adminFetcher = $adminFetcher;
        $this->positionHandler = $positionHandler;
    }

    public function __invoke(Request $request, string $position): Response
    {
        $admin = $this->adminFetcher->get($request);

        if (!$admin->isGranted('EDIT')) {
            $this->addFlash(
                'sonata_flash_error',
                $this->translator->trans('flash_error_no_rights_update_position')
            );

            return new RedirectResponse($admin->generateUrl(
                'list',
                ['filter' => $admin->getFilterParameters()]
            ));
        }

        if ($admin->hasSubject()) {
            $object = $admin->getSubject();
            $this->positionHandler->move($object, $position);

            if ($request->isXmlHttpRequest()) {
                return new JsonResponse([
                    'result' => 'ok',
                    'objectId' => $admin->getNormalizedIdentifier($object),
                ]);
            }

            $this->addFlash(
                'sonata_flash_success',
                $this->translator->trans('flash_success_position_updated')
            );
        }

        return new RedirectResponse($admin->generateUrl(
            'list',
            ['filter' => $admin->getFilterParameters()]
        ));
    }
}
