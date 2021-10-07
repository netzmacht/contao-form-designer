<?php

/**
 * Contao Form Designer.
 *
 * @filesource
 */

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\Factory;

use Contao\StringUtil;
use Netzmacht\Contao\FormDesigner\Layout\ContaoFormLayout;
use Netzmacht\Contao\FormDesigner\Layout\FormLayout;

use function ucfirst;

class StandardFormLayoutFactory implements FormLayoutFactory
{
    /**
     * Widget config.
     *
     * @var array<string,array<string,mixed>>
     */
    private $widgetConfig;

    /**
     * Fallback config.
     *
     * @var array<string,array<string,mixed>>
     */
    private $fallbackConfig;

    /**
     * Sections of the form.
     *
     * @var list<string>
     */
    private $sections = ['layout', 'label', 'control', 'error', 'help'];

    /**
     * @param array<string,array<string,mixed>> $widgetConfig   Widget config map.
     * @param array<string,array<string,mixed>> $fallbackConfig Control fallback config.
     */
    public function __construct(array $widgetConfig, array $fallbackConfig)
    {
        $this->widgetConfig   = $widgetConfig;
        $this->fallbackConfig = $fallbackConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function create(string $type, array $config): FormLayout
    {
        $widgetConfig      = $this->buildWidgetConfig($config);
        $fallbackTemplates = $this->buildFallbackConfig($config);

        return new ContaoFormLayout($widgetConfig, $fallbackTemplates);
    }

    /**
     * {@inheritdoc}
     */
    public function supportedTypes(): array
    {
        return ['standard'];
    }

    /**
     * Build the widget config.
     *
     * @param array<string,mixed> $config Configuration.
     *
     * @return array<string,mixed>
     */
    private function buildWidgetConfig(array $config): array
    {
        $widgetConfig = $this->widgetConfig;

        foreach (StringUtil::deserialize($config['widgets'], true) as $widget) {
            if ($widget['widget'] === '') {
                continue;
            }

            foreach ($this->sections as $section) {
                if (! $widget[$section]) {
                    continue;
                }

                $widgetConfig[$widget['widget']]['templates'][$section] = $widget[$section];
            }
        }

        return $widgetConfig;
    }

    /**
     * Build the fallback config.
     *
     * @param array<string,mixed> $config Configuration.
     *
     * @return array<string,mixed>
     */
    private function buildFallbackConfig(array $config): array
    {
        $fallbackConfig = $this->fallbackConfig;

        foreach ($this->sections as $section) {
            $name = 'fallback' . ucfirst($section);

            if (! $config[$name]) {
                continue;
            }

            $fallbackConfig[$section] = $config[$name];
        }

        return $fallbackConfig;
    }
}
