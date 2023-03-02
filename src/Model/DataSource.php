<?php

declare(strict_types=1);

namespace App\Model;

use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Sonata\AdminBundle\Exporter\DataSourceInterface;
use Sonata\Exporter\Source\ArraySourceIterator;

final class DataSource implements DataSourceInterface
{
    public function createIterator(ProxyQueryInterface $query, array $fields): \Iterator
    {
        return new ArraySourceIterator([]);
    }
}
