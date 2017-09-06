<?php

/**
 * @package    contao-form-designer
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormDesigner;

use Netzmacht\Contao\FormDesigner\Exception\CreatingLayoutFailed;
use Netzmacht\Contao\FormDesigner\Factory\LayoutTypeFactory;
use Netzmacht\Contao\FormDesigner\Layout\FormLayout;

/**
 * Class FormLayoutFactory.
 *
 * @package Netzmacht\Contao\FormDesigner
 */
class FormLayoutFactory
{
    /**
     * Factories map.
     *
     * @var LayoutTypeFactory[]
     */
    private $factories = [];

    /**
     * FormLayoutFactory constructor.
     *
     * @param LayoutTypeFactory[] $factories
     */
    public function __construct(array $factories)
    {
        $this->factories = $factories;
    }

    /**
     * Create form layout for a widget.
     *
     * @param string $type   Form layout type.
     * @param array  $config Form layout config.
     *
     * @return FormLayout
     * @throws CreatingLayoutFailed
     */
    public function create($type, array $config)
    {
        if (isset ($this->factories[$type])) {
            return $this->factories[$type]->create($config);
        }

        throw CreatingLayoutFailed::unsupportedType($type);
    }
}
