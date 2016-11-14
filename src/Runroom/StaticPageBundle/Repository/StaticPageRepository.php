<?php

namespace Runroom\StaticPageBundle\Repository;

use Doctrine\ORM\EntityManager;

class StaticPageRepository
{
    const FOOTER = 'footer';

    protected $entity_manager;

    public function __construct(EntityManager $entity_manager)
    {
        $this->entity_manager = $entity_manager;
    }

    public function findStaticPage($static_page_slug)
    {
        $builder = $this->entity_manager->createQueryBuilder();
        $query = $builder
            ->select('static_page')
            ->from('RunroomStaticPageBundle:StaticPage', 'static_page')
            ->leftJoin('static_page.translations', 'translations')
            ->where('translations.slug = :slug')
            ->andWhere('static_page.publish = true')
            ->setParameter('slug', $static_page_slug)
            ->getQuery();

        return $query->getSingleResult();
    }
}
