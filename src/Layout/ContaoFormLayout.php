<?php

/**
 * Contao Form Designer.
 *
 * @filesource
 */

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\Layout;

use Contao\Widget;
use Netzmacht\Contao\FormDesigner\Util\WidgetUtil;

final class ContaoFormLayout extends AbstractFormLayout
{
    /**
     * Fallback templates config.
     *
     * @var array<string,array<string,mixed>>
     */
    private $fallbackConfig;

    /**
     * @param array<string,array<string,mixed>> $widgetConfig   Widget config map.
     * @param array<string,array<string,mixed>> $fallbackConfig Control fallback config.
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
     */
    protected function getTemplate(Widget $widget, string $section): string
    {
        $type = WidgetUtil::getType($widget);

        if ($section === 'help' && empty($this->widgetConfig[$type]['help'])) {
            return '';
        }

        if (isset($this->widgetConfig[$type]['templates'][$section])) {
            return $this->widgetConfig[$type]['templates'][$section];
        }

        if (isset($this->fallbackConfig['templates'][$section])) {
            return $this->fallbackConfig['templates'][$section];
        }

        return '';
    }
}
