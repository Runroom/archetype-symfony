<?php

declare(strict_types=1);

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    public function registerBundles(): array
    {
        $bundles = [
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),

            new A2lix\TranslationFormBundle\A2lixTranslationFormBundle(),
            new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new FOS\CKEditorBundle\FOSCKEditorBundle(),
            new Knp\Bundle\MarkdownBundle\KnpMarkdownBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Knp\DoctrineBehaviors\Bundle\DoctrineBehaviorsBundle(),
            new Pix\SortableBehaviorBundle\PixSortableBehaviorBundle(),
            new Sonata\AdminBundle\SonataAdminBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),
            new Sonata\FormatterBundle\SonataFormatterBundle(),
            new Sonata\MediaBundle\SonataMediaBundle(),
            new Sonata\UserBundle\SonataUserBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),

            new Archetype\DemoBundle\ArchetypeDemoBundle(),
            new Runroom\RedirectionsBundle\RunroomRedirectionsBundle(),
            new Runroom\BaseBundle\RunroomBaseBundle(),
            new Runroom\StaticPageBundle\RunroomStaticPageBundle(),
            new Runroom\TranslationsBundle\RunroomTranslationsBundle(),
        ];

        if (\in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();

            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();

            if ($this->getEnvironment() === 'dev') {
                $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            }
        }

        return $bundles;
    }

    public function getCacheDir(): string
    {
        return \dirname($this->getRootDir()) . '/var/cache/' . $this->getEnvironment();
    }

    public function getLogDir(): string
    {
        return \dirname($this->getRootDir()) . '/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load($this->getRootDir() . '/config/config_' . $this->getEnvironment() . '.yml');
    }
}
