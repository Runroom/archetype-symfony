<?php

declare(strict_types=1);

namespace App\Model;

use App\DTO\Random;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;

final class ProxyQuery implements ProxyQueryInterface
{
    public $maxResults = null;
    public $firstResult = null;

    public function execute()
    {
        dump($this);
        $api = [];

        for ($i = 0; $i < 200; $i++) {
            $api[] = new Random('test' . $i);
        }

        return array_slice($api, $this->firstResult ?? 0, $this->maxResults);
    }

    public function setSortBy(array $parentAssociationMappings, array $fieldMapping): ProxyQueryInterface
    {
        throw new \BadMethodCallException('Not implemented.');
    }

    public function getSortBy(): ?string
    {
        throw new \BadMethodCallException('Not implemented4.');
    }

    public function setSortOrder(string $sortOrder): ProxyQueryInterface
    {
        throw new \BadMethodCallException('Not implemented.');
    }

    public function getSortOrder(): ?string
    {
        throw new \BadMethodCallException('Not implemented.');
    }

    public function setFirstResult(?int $firstResult): ProxyQueryInterface
    {
        $this->firstResult = $firstResult;

        return $this;
    }

    public function getFirstResult(): ?int
    {
        return $this->firstResult;
    }

    public function setMaxResults(?int $maxResults): ProxyQueryInterface
    {
        $this->maxResults = $maxResults;

        return $this;
    }

    public function getMaxResults(): ?int
    {
        return $this->maxResults;
    }
}
