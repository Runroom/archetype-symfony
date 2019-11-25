<?php

namespace Runroom\StaticPageBundle\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Join;
use Runroom\StaticPageBundle\Entity\StaticPage;
use Symfony\Component\HttpFoundation\RequestStack;

class StaticPageRepository
{
    protected $entityManager;
    protected $requestStack;

    public function __construct(
        EntityManagerInterface $entityManager,
        RequestStack $requestStack
    ) {
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
    }

    public function findStaticPage(string $staticPageSlug): StaticPage
    {
        $builder = $this->entityManager->createQueryBuilder();
        $request = $this->requestStack->getCurrentRequest();

        $query = $builder
            ->select('static_page')
            ->from('RunroomStaticPageBundle:StaticPage', 'static_page')
            ->leftJoin('static_page.translations', 'translations', Join::WITH, 'translations.locale = :locale')
            ->where('translations.slug = :slug')
            ->andWhere('static_page.publish = true')
            ->setParameter('slug', $staticPageSlug)
            ->setParameter('locale', $request->getLocale())
            ->getQuery();

        return $query->getSingleResult();
    }

    public function findVisibleStaticPages(): array
    {
        $builder = $this->entityManager->createQueryBuilder();
        $query = $builder
            ->select('static_page')
            ->from('RunroomStaticPageBundle:StaticPage', 'static_page')
            ->where('static_page.publish = true')
            ->andWhere('static_page.location != :location')
            ->setParameter('location', StaticPage::LOCATION_NONE)
            ->getQuery();

        return $query->getResult();
    }
}
