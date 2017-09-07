<?php

/**
 * @package    contao-form-designer
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormDesigner\Factory;

use Netzmacht\Contao\FormDesigner\Layout\ContaoFormLayout;

/**
 * Class DefaultFormLayoutFactory
 *
 * @package Netzmacht\Contao\FormDesigner\Factory
 */
class StandardFormLayoutFactory implements FormLayoutFactory
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
     * Sections of the form.
     *
     * @var array
     */
    private $sections = ['layout', 'label', 'control', 'error', 'help'];

    /**
     * AbstractFormLayout constructor.
     *
     * @param array $widgetConfig      Control template map.
     * @param array $fallbackTemplates Control fallback template.
     */
    public function __construct (array $widgetConfig, array $fallbackTemplates)
    {
        $this->widgetConfig      = $widgetConfig;
        $this->fallbackTemplates = $fallbackTemplates;
    }

    /**
     * {@inheritdoc}
     */
    public function create ($type, array $config)
    {
        $widgetConfig      = $this->buildWidgetConfig($config);
        $fallbackTemplates = $this->buildFallbackTemplates($config);

        return new ContaoFormLayout($widgetConfig, $fallbackTemplates);
    }

    /**
     * {@inheritdoc}
     */
    public function supportedTypes ()
    {
        return ['standard'];
    }

    /**
     * Build the widget config.
     *
     * @param array $config Configuration.
     *
     * @return array
     */
    private function buildWidgetConfig (array $config)
    {
        $widgetConfig = $this->widgetConfig;

        foreach (deserialize($config['widgets'], true) as $widget) {
            if ($widget['widget'] === '') {
                continue;
            }

            foreach ($this->sections as $section) {
                if ($widget[$section] === 'fallback') {
                    unset ($widgetConfig[$widget['widget']][$section]);
                } elseif ($widget[$section]) {
                    $widgetConfig[$widget['widget']][$section] = $widget[$section];
                }
            }
        }

        return $widgetConfig;
    }

    /**
     * Build the fallback templates.
     *
     * @param array $config Configuration.
     *
     * @return array
     */
    private function buildFallbackTemplates (array $config)
    {
        $fallbackTemplates = $this->fallbackTemplates;

        foreach ($this->sections as $section) {
            $name = 'fallback' . ucfirst($section);

            if ($config[$name] === 'fallback') {
                unset ($fallbackTemplates[$section]);
            } elseif ($config[$name]) {
                $fallbackTemplates[$section] = $config[$name];
            }
        }

        return $fallbackTemplates;
    }
}
