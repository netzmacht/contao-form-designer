<?php

/**
 * @package    contao-form-designer
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormDesigner\Layout;

use Contao\Widget;
use Netzmacht\Html\Attributes;

/**
 * Class ContaoFormLayout.
 *
 * @package Netzmacht\Contao\FormDesigner\Layout
 */
final class ContaoFormLayout extends AbstractFormLayout
{
    /**
     * Widget config.
     *
     * @var array
     */
    private $widgetConfig;

    /**
     * Fallback templates map.
     *
     * @var array
     */
    private $fallbackTemplates;

    /**
     * AbstractFormLayout constructor.
     *
     * @param array $widgetConfig      Control template map.
     * @param array $fallbackTemplates Control fallback template.
     */
    public function __construct(array $widgetConfig, array $fallbackTemplates)
    {
        $this->widgetConfig      = $widgetConfig;
        $this->fallbackTemplates = $fallbackTemplates;
    }

    /**
     * {@inheritdoc}
     */
    public function getContainerAttributes(Widget $widget)
    {
        $attributes = new Attributes();
        $attributes
            ->addClass('form-widget')
            ->addClass('form-' . $widget->type);

        if ($widget->class) {
            $attributes->addClass($widget->class);
        }

        return $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function getLabelAttributes(Widget $widget)
    {
        $attributes = new Attributes();
        $attributes->setAttribute('for', 'ctrl_' . $widget->id);

        if ($widget->class) {
            $attributes->addClass($widget->class);
        }

        return $attributes;
    }

    /**
     * {@inheritdoc}
     */
    protected function getLayoutTemplate(Widget $widget)
    {
        return $this->getTemplate($widget, 'layout');
    }

    /**
     * {@inheritdoc}
     */
    protected function getControlTemplate(Widget $widget)
    {
        return $this->getTemplate($widget, 'control');
    }

    /**
     * {@inheritdoc}
     */
    protected function getLabelTemplate(Widget $widget)
    {
        return $this->getTemplate($widget, 'label');
    }

    /**
     * {@inheritdoc}
     */
    protected function getErrorTemplate(Widget $widget)
    {
        return $this->getTemplate($widget, 'error');
    }

    /**
     * Get a template for a section.
     *
     * @param Widget $widget  Widget.
     * @param string $section Section
     *
     * @return string
     */
    private function getTemplate(Widget $widget, $section)
    {
        if (isset($this->widgetConfig[$widget->type][$section])) {
            return $this->widgetConfig[$widget->type][$section];
        }

        if (isset($this->fallbackTemplates[$section])) {
            return $this->fallbackTemplates[$section];
        }

        return '';
    }
}
