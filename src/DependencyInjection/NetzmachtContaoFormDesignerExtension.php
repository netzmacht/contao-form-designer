<?php

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\DependencyInjection;

use Contao\CoreBundle\ContaoCoreBundle;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

use function method_exists;

class NetzmachtContaoFormDesignerExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config'),
        );

        $config = $this->processConfiguration(new Configuration(), $configs);

        // BC compatibility for repeated password field
        if (! method_exists(ContaoCoreBundle::class, 'getVersion')) {
            $template = $config['widgets']['password']['templates']['layout'] ?? null;
            if ($template === 'fd_layout_row') {
                $config['widgets']['password']['templates']['layout'] = 'fd_layout_row_password';
            }
        }

        $container->setParameter('netzmacht.contao_form_designer.widgets', $config['widgets']);
        $container->setParameter('netzmacht.contao_form_designer.form_designer.elements', $config['elements']);
        $container->setParameter('netzmacht.contao_form_designer.form_designer.modules', $config['modules']);
        $container->setParameter(
            'netzmacht.contao_form_designer.form_designer.virtual_widgets',
            $config['virtual_widgets'],
        );

        $loader->load('services.yml');
        $loader->load('listeners.yml');
    }
}
