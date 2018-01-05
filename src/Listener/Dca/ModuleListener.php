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

namespace Netzmacht\Contao\FormDesigner\Listener\Dca;

use ContaoCommunityAlliance\MetaPalettes\MetaPalettes;
use Netzmacht\Contao\FormDesigner\Listener\Dca\Plugin\FormLayoutOptionsPlugin;
use Netzmacht\Contao\FormDesigner\Model\FormLayout\FormLayoutRepository;

/**
 * Class ModuleListener.
 *
 * @package Netzmacht\Contao\FormDesigner\Listener\Dca
 */
class ModuleListener
{
    use FormLayoutOptionsPlugin;

    /**
     * List of supported modules.
     *
     * @var array
     */
    private $supportedModules;

    /**
     * ModuleListener constructor.
     *
     * @param FormLayoutRepository $formLayoutRepository Form layout repository.
     * @param array                $supportedModules     Supported modules.
     */
    public function __construct(FormLayoutRepository $formLayoutRepository, array $supportedModules)
    {
        $this->supportedModules     = $supportedModules;
        $this->formLayoutRepository = $formLayoutRepository;
    }

    /**
     * Initialize.
     *
     * @return void
     */
    public function initialize(): void
    {
        foreach ($this->supportedModules as $module) {
            MetaPalettes::appendFields('tl_module', $module, 'include', ['formLayout']);
        }
    }
}
