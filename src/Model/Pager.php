<?php

declare(strict_types=1);

namespace App\Model;

use Sonata\AdminBundle\Datagrid\Pager as BasePager;

final class Pager extends BasePager
{
    private int $resultsCount = 0;

    public function init(): void {
        dump($this->getPage());
        $query = $this->getQuery();

        $this->resultsCount = \count($query->execute());

        $query->setFirstResult(null);
        $query->setMaxResults(null);

        if (0 === $this->getPage() || 0 === $this->getMaxPerPage()) {
            $this->setLastPage(0);
        } elseif (0 === $this->countResults()) {
            $this->setLastPage(1);
        } else {
            $offset = ($this->getPage() - 1) * $this->getMaxPerPage();

            $this->setLastPage((int) ceil($this->countResults() / $this->getMaxPerPage()));

            $query->setFirstResult($offset);
            $query->setMaxResults($this->getMaxPerPage());
        }
    }

    public function getCurrentPageResults(): iterable
    {
        return $this->getQuery()->execute();
    }

    public function countResults(): int
    {
        return $this->resultsCount;
    }
}
