<?php

/**
 * @package    contao-form-designer
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormDesigner\Listener\Dca;

use Bit3\Contao\MetaPalettes\MetaPalettes;

/**
 * Class ModuleListener
 *
 * @package Netzmacht\Contao\FormDesigner\Listener\Dca
 */
class ModuleListener
{
    /**
     * @var
     */
    private $supportedModules;

    /**
     * ModuleListener constructor.
     *
     * @param $supportedModules
     */
    public function __construct ($supportedModules)
    {
        $this->supportedModules = $supportedModules;
    }

    /**
     *
     */
    public function initialize()
    {
        foreach ($this->supportedModules as $module) {
            MetaPalettes::appendFields('tl_module', $module, 'template', ['formLayout']);
        }
    }
}
