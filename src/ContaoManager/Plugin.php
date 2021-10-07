<?php

/**
 * Contao Form Designer.
 *
 * @filesource
 */

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Netzmacht\Contao\FormDesigner\NetzmachtContaoFormDesignerBundle;

class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(NetzmachtContaoFormDesignerBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}
