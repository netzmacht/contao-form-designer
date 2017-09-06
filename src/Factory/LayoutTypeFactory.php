<?php

/**
 * @package    contao-form-designer
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormDesigner\Factory;

use Netzmacht\Contao\FormDesigner\Layout\FormLayout;

/**
 * Interface LayoutTypeFactory
 *
 * @package Netzmacht\Contao\FormDesigner\Factory
 */
interface LayoutTypeFactory
{
    /**
     * Create the layout for a widget.
     *
     * @param array $config Form layout config.
     *
     * @return FormLayout
     */
    public function create(array $config);
}
