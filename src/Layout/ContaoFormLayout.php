<?php

/**
 * @package    contao-form-designer
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
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
     * Widget config.
     *
     * @var array
     */
    private $widgetConfig;

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
        $this->widgetConfig   = $widgetConfig;
        $this->fallbackConfig = $fallbackConfig;
    }

    /**
     * {@inheritdoc}
     */
    protected function getLayoutTemplate(Widget $widget): string
    {
        return $this->getTemplate($widget, 'layout');
    }

    /**
     * {@inheritdoc}
     */
    protected function getControlTemplate(Widget $widget): string
    {
        return $this->getTemplate($widget, 'control');
    }

    /**
     * {@inheritdoc}
     */
    protected function getLabelTemplate(Widget $widget): string
    {
        return $this->getTemplate($widget, 'label');
    }

    /**
     * {@inheritdoc}
     */
    protected function getErrorTemplate(Widget $widget): string
    {
        return $this->getTemplate($widget, 'error');
    }

    /**
     * {@inheritdoc}
     */
    protected function getHelpTextTemplate(Widget $widget): string
    {
        if (empty($this->widgetConfig[$widget->type]['help'])) {
            return '';
        }

        return $this->getTemplate($widget, 'help');
    }

    /**
     * Get a template for a section.
     *
     * @param Widget $widget  Widget.
     * @param string $section Section.
     *
     * @return string
     */
    private function getTemplate(Widget $widget, $section): string
    {
        if (isset($this->widgetConfig[$widget->type]['templates'][$section])) {
            return $this->widgetConfig[$widget->type]['templates'][$section];
        }

        if (isset($this->fallbackConfig['templates'][$section])) {
            return $this->fallbackConfig['templates'][$section];
        }

        return '';
    }
}
