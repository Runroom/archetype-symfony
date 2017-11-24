<?php

namespace Runroom\StaticPageBundle\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Runroom\StaticPageBundle\Entity\StaticPage;

class StaticPageRepository
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findStaticPage(string $staticPageSlug): StaticPage
    {
        $builder = $this->entityManager->createQueryBuilder();
        $query = $builder
            ->select('static_page')
            ->from('RunroomStaticPageBundle:StaticPage', 'static_page')
            ->leftJoin('static_page.translations', 'translations')
            ->where('translations.slug = :slug')
            ->andWhere('static_page.publish = true')
            ->setParameter('slug', $staticPageSlug)
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
