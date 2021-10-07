<?php

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner;

use Netzmacht\Contao\FormDesigner\DependencyInjection\FormLayoutFactoryCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Bundle class of the contao form designer.
 */
class NetzmachtContaoFormDesignerBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new FormLayoutFactoryCompilerPass());
    }
}
