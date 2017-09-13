<?php

/**
 * Contao Form Designer.
 *
 * @package    contao-form-designer
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @license    LGPL 3.0
 * @filesource
 */

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class FormLayoutFactoryCompilerPass.
 *
 * @package Netzmacht\Contao\FormDesigner\DependencyInjection
 */
class FormLayoutFactoryCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('netzmacht.contao_form_designer.layout_factory')) {
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
