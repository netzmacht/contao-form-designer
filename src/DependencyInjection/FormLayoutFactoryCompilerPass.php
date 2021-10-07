<?php

/**
 * Contao Form Designer.
 *
 * @filesource
 */

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

use function array_keys;

class FormLayoutFactoryCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (! $container->has('netzmacht.contao_form_designer.layout_factory')) {
            return;
        }

        $definition       = $container->findDefinition('netzmacht.contao_form_designer.layout_factory');
        $taggedServiceIds = $container->findTaggedServiceIds('netzmacht.contao_form_designer.factory');
        $services         = (array) $definition->getArgument(0);

        foreach (array_keys($taggedServiceIds) as $serviceId) {
            $services[] = new Reference($serviceId);
        }

        $definition->replaceArgument(0, $services);
    }
}
