<?php

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class NetzmachtContaoFormDesignerExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );

        $config = $this->processConfiguration(new Configuration(), $configs);

        $container->setParameter('netzmacht.contao_form_designer.widgets', $config['widgets']);
        $container->setParameter('netzmacht.contao_form_designer.form_designer.elements', $config['elements']);
        $container->setParameter('netzmacht.contao_form_designer.form_designer.modules', $config['modules']);
        $container->setParameter(
            'netzmacht.contao_form_designer.form_designer.virtual_widgets',
            $config['virtual_widgets']
        );

        $loader->load('services.yml');
        $loader->load('listeners.yml');
    }
}
