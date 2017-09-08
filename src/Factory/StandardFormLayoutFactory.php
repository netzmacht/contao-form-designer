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
 * Class DefaultFormLayoutFactory.
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
     * Fallback config.
     *
     * @var array
     */
    private $fallbackConfig;

    /**
     * Sections of the form.
     *
     * @var array
     */
    private $sections = ['layout', 'label', 'control', 'error', 'help'];

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
    public function create($type, array $config)
    {
        $widgetConfig      = $this->buildWidgetConfig($config);
        $fallbackTemplates = $this->buildFallbackConfig($config);

        return new ContaoFormLayout($widgetConfig, $fallbackTemplates);
    }

    /**
     * {@inheritdoc}
     */
    public function supportedTypes()
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
    private function buildWidgetConfig(array $config)
    {
        $widgetConfig = $this->widgetConfig;

        foreach (deserialize($config['widgets'], true) as $widget) {
            if ($widget['widget'] === '') {
                continue;
            }

            foreach ($this->sections as $section) {
                if ($widget[$section]) {
                    $widgetConfig[$widget['widget']]['templates'][$section] = $widget[$section];
                }
            }
        }

        return $widgetConfig;
    }

    /**
     * Build the fallback config.
     *
     * @param array $config Configuration.
     *
     * @return array
     */
    private function buildFallbackConfig(array $config)
    {
        $fallbackConfig = $this->fallbackConfig;

        foreach ($this->sections as $section) {
            $name = 'fallback' . ucfirst($section);

            if ($config[$name]) {
                $fallbackConfig[$section] = $config[$name];
            }
        }

        return $fallbackConfig;
    }
}
