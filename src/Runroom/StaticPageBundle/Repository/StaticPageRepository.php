<?php

namespace Runroom\StaticPageBundle\Repository;

use Doctrine\ORM\EntityManager;

class StaticPageRepository
{
    const FOOTER = 'footer';

    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findStaticPage($staticPageSlug)
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
}
