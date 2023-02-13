<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\TreeInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TreeSelectorType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $entityNormalizer = function (Options $options, $value) {
            if (null === $value) {
                return null;
            }

            if ($value instanceof $options['class']) {
                return $value;
            }

            throw new UnexpectedTypeException($value, $options['class']);
        };

        $resolver->setDefaults([
            'subject' => null,
            'root' => null,
            'max_depth' => null,
            'query_builder' => fn(Options $options) => fn(EntityRepository $repository) => $this->buildQueryBuilder(
                $repository,
                $options['max_depth'],
                $options['subject'],
                $options['root']
            ),
        ]);

        $resolver->setNormalizer('subject', $entityNormalizer);
        $resolver->setNormalizer('root', $entityNormalizer);
        $resolver->setAllowedTypes('max_depth', ['null', 'int']);
    }

    public function getParent(): string
    {
        return EntityType::class;
    }

    /**
     * @param EntityRepository<TreeInterface> $repository
     */
    private function buildQueryBuilder(
        EntityRepository $repository,
        int $maxDepth = null,
        TreeInterface $subject = null,
        TreeInterface $root = null
    ): QueryBuilder {
        $query = $repository->createQueryBuilder('tree')
            ->orderBy('tree.root', 'ASC')
            ->addorderBy('tree.lft', 'ASC');

        $nestedLevel = 1;

        if (null !== $subject && null !== $subject->getLft() && null !== $subject->getRgt()) {
            $nestedLevel = $this->getMaxNestedLevel($repository, $subject);

            $query->andWhere('not (tree.lft >= :lft and tree.rgt <= :rgt)');
            $query->setParameter('lft', $subject->getLft());
            $query->setParameter('rgt', $subject->getRgt());
        }

        if (null !== $root) {
            $query->andWhere('tree.root = :root');
            $query->setParameter('root', $root);
        }

        if (null !== $maxDepth) {
            $query->andWhere('tree.lvl <= :max_depth');
            $query->setParameter('max_depth', $maxDepth - $nestedLevel);
        }

        return $query;
    }

    /**
     * @param EntityRepository<TreeInterface> $repository
     */
    private function getMaxNestedLevel(EntityRepository $repository, TreeInterface $node): int
    {
        $query = $repository->createQueryBuilder('tree');

        $query
            ->where('tree.lft >= :lft')
            ->andWhere('tree.rgt <= :rgt')
            ->setParameter('lft', $node->getLft())
            ->setParameter('rgt', $node->getRgt())
            ->orderBy('tree.lvl', 'DESC')
            ->setMaxResults(1);

        $maxLvlLeaf = $query->getQuery()->getOneOrNullResult();

        return $maxLvlLeaf?->getLvl() ?? 0;
    }
}
