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

namespace Netzmacht\Contao\FormDesigner\Layout;

use Contao\Widget;

/**
 * Class ContaoFormLayout.
 *
 * @package Netzmacht\Contao\FormDesigner\Layout
 */
final class ContaoFormLayout extends AbstractFormLayout
{
    /**
     * Fallback templates config.
     *
     * @var array
     */
    private $fallbackConfig;

    /**
     * AbstractFormLayout constructor.
     *
     * @param array $widgetConfig   Widget config map.
     * @param array $fallbackConfig Control fallback config.
     */
    public function __construct(array $widgetConfig, array $fallbackConfig)
    {
        parent::__construct($widgetConfig);

        $this->fallbackConfig = $fallbackConfig;
    }

    /**
     * Get a template for a section.
     *
     * @param Widget $widget  Widget.
     * @param string $section Section.
     *
     * @return string
     */
    protected function getTemplate(Widget $widget, string $section): string
    {
        if ($section === 'help' && empty($this->widgetConfig[$widget->type]['help'])) {
            return '';
        }

        if (isset($this->widgetConfig[$widget->type]['templates'][$section])) {
            return $this->widgetConfig[$widget->type]['templates'][$section];
        }

        if (isset($this->fallbackConfig['templates'][$section])) {
            return $this->fallbackConfig['templates'][$section];
        }

        return '';
    }
}
