<?php

namespace Runroom\StaticPageBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;
use Runroom\StaticPageBundle\Entity\StaticPage;
use Symfony\Component\HttpFoundation\RequestStack;

class StaticPageRepository extends ServiceEntityRepository
{
    protected $requestStack;

    public function __construct(ManagerRegistry $registry, RequestStack $requestStack)
    {
        parent::__construct($registry, StaticPage::class);

        $this->requestStack = $requestStack;
    }

    public function findBySlug(string $slug): StaticPage
    {
        $request = $this->requestStack->getCurrentRequest();

        $query = $this->createQueryBuilder('static_page')
            ->leftJoin('static_page.translations', 'translations', Join::WITH, 'translations.locale = :locale')
            ->where('translations.slug = :slug')
            ->andWhere('static_page.publish = true')
            ->setParameter('slug', $slug)
            ->setParameter('locale', $request->getLocale())
            ->getQuery();

        return $query->getSingleResult();
    }
}
