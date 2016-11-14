<?php

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),

            new A2lix\TranslationFormBundle\A2lixTranslationFormBundle(),
            new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Knp\DoctrineBehaviors\Bundle\DoctrineBehaviorsBundle(),
            new Knp\Bundle\MarkdownBundle\KnpMarkdownBundle(),
            new Pix\SortableBehaviorBundle\PixSortableBehaviorBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),

            new Sonata\AdminBundle\SonataAdminBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Sonata\ClassificationBundle\SonataClassificationBundle(),
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            new Sonata\EasyExtendsBundle\SonataEasyExtendsBundle(),
            new Sonata\FormatterBundle\SonataFormatterBundle(),
            new Sonata\IntlBundle\SonataIntlBundle(),
            new Sonata\MediaBundle\SonataMediaBundle(),
            new Sonata\UserBundle\SonataUserBundle('FOSUserBundle'),

            new Application\Sonata\ClassificationBundle\ApplicationSonataClassificationBundle(),
            new Application\Sonata\MediaBundle\ApplicationSonataMediaBundle(),
            new Application\Sonata\UserBundle\ApplicationSonataUserBundle(),
            new Runroom\BaseBundle\RunroomBaseBundle(),
            new Runroom\EntitiesBundle\RunroomEntitiesBundle(),
            new Runroom\StaticPageBundle\RunroomStaticPageBundle(),

            new Archetype\DemoBundle\ArchetypeDemoBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();

            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir() . '/config/config_' . $this->getEnvironment() . '.yml');
    }
}
