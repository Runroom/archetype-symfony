<?php

declare(strict_types=1);

namespace App\EventListener;

use Doctrine\DBAL\Schema\AbstractAsset;
use Doctrine\Migrations\Metadata\Storage\TableMetadataStorageConfiguration;
use Doctrine\Migrations\Tools\Console\Command\DoctrineCommand;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Prevent Doctrine migrations tracking table to be dropped by the Doctrine's schema tool.
 */
#[AutoconfigureTag('doctrine.dbal.schema_filter')]
class DoctrineMigrationsFilter implements EventSubscriberInterface
{
    private bool $enabled = true;

    public function __invoke(AbstractAsset|string $asset): bool
    {
        if (!$this->enabled) {
            return true;
        }

        if (!class_exists(TableMetadataStorageConfiguration::class)) {
            return true;
        }

        if ($asset instanceof AbstractAsset) {
            $asset = $asset->getName();
        }

        return $asset !== (new TableMetadataStorageConfiguration())->getTableName();
    }

    public function onConsoleCommand(ConsoleCommandEvent $event): void
    {
        $command = $event->getCommand();

        if (null === $command) {
            return;
        }

        /*
         * Any console commands from the Doctrine Migrations bundle may attempt
         * to initialize migrations information storage table. Because of this
         * they should not be affected by this filter because their logic may
         * get broken since they will not "see" the table, they may try to use
         */
        if ($command instanceof DoctrineCommand) {
            $this->enabled = false;
        }
    }

    #[\Override]
    public static function getSubscribedEvents(): array
    {
        return [
            ConsoleEvents::COMMAND => 'onConsoleCommand',
        ];
    }
}
