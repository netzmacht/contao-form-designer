<?php

/**
 * Contao Form Designer.
 *
 * @filesource
 */

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\Layout;

use Contao\FrontendTemplate;
use Contao\StringUtil;
use Contao\Widget;
use Netzmacht\Contao\FormDesigner\Util\WidgetUtil;
use Netzmacht\Html\Attributes;
use Netzmacht\Html\Exception\InvalidArgumentException;

use function gettype;
use function in_array;

abstract class AbstractFormLayout implements FormLayout
{
    /**
     * Widget config.
     *
     * @var array<string,array<string,mixed>>
     */
    protected $widgetConfig;

    /**
     * If boolean attribute.
     *
     * @var list<string>
     */
    protected static $booleanAttributes = [
        'compact',
        'declare',
        'defer',
        'disabled',
        'formnovalidate',
        'multiple',
        'nowrap',
        'novalidate',
        'ismap',
        'itemscope',
        'readonly',
        'required',
        'selected',
    ];

    /**
     * @param array<string,array<string,mixed>> $widgetConfig Widget config.
     */
    public function __construct(array $widgetConfig)
    {
        $this->widgetConfig = $widgetConfig;
    }

    public function render(Widget $widget): string
    {
        return $this->renderBlock($widget, $this->getLayoutTemplate($widget));
    }

    public function renderControl(Widget $widget): string
    {
        return $this->renderBlock($widget, $this->getControlTemplate($widget));
    }

    public function renderLabel(Widget $widget): string
    {
        return $this->renderBlock($widget, $this->getLabelTemplate($widget));
    }

    public function renderErrors(Widget $widget): string
    {
        return $this->renderBlock($widget, $this->getErrorTemplate($widget));
    }

    public function renderHelpText(Widget $widget): string
    {
        return $this->renderBlock($widget, $this->getHelpTextTemplate($widget));
    }

    public function getContainerAttributes(Widget $widget): Attributes
    {
        $attributes = new Attributes();
        $attributes
            ->addClass('widget')
            ->addClass('widget-' . WidgetUtil::getType($widget));

        if ($widget->class) {
            $attributes->addClass($widget->class);
        }

        return $attributes;
    }

    public function getLabelAttributes(Widget $widget): Attributes
    {
        $attributes = new Attributes();
        $attributes->setAttribute('for', 'ctrl_' . $widget->id);

        if ($widget->class) {
            $attributes->addClass($widget->class);
        }

        return $attributes;
    }

    public function getControlAttributes(Widget $widget): Attributes
    {
        $attributes = new Attributes();
        $attributes->setId('ctrl_' . $widget->id);
        $attributes->setAttribute('name', $widget->name);
        $this->addConfiguredAttributes($widget, $attributes);
        $this->parseWidgetAttributes($widget, $attributes);

        if ($widget->class) {
            $attributes->addClass($widget->class);
        }

        if ($widget->controlClass) {
            $attributes->addClass($widget->controlClass);
        }

        return $attributes;
    }

    /**
     * Render the widget.
     *
     * @param Widget $widget   Form widget.
     * @param string $template Template name.
     */
    protected function renderBlock(Widget $widget, string $template): string
    {
        if (! $template) {
            return '';
        }

        $template = new FrontendTemplate($template);
        $template->setData(
            [
                'widget' => $widget,
                'layout' => $this,
            ]
        );

        return $template->parse();
    }

    /**
     * Get the layout template.
     *
     * @param Widget $widget Form widget.
     */
    protected function getLayoutTemplate(Widget $widget): string
    {
        return $this->getTemplate($widget, 'layout');
    }

    /**
     * Get the control template.
     *
     * @param Widget $widget Form widget.
     */
    protected function getControlTemplate(Widget $widget): string
    {
        return $this->getTemplate($widget, 'control');
    }

    /**
     * Get the label template.
     *
     * @param Widget $widget Form widget.
     */
    protected function getLabelTemplate(Widget $widget): string
    {
        return $this->getTemplate($widget, 'label');
    }

    /**
     * Get the error template.
     *
     * @param Widget $widget Form widget.
     */
    protected function getErrorTemplate(Widget $widget): string
    {
        return $this->getTemplate($widget, 'error');
    }

    protected function getHelpTextTemplate(Widget $widget): string
    {
        return $this->getTemplate($widget, 'help');
    }

    /**
     * Get the help text template.
     *
     * @param Widget $widget  Form widget.
     * @param string $section Form widget section.
     */
    abstract protected function getTemplate(Widget $widget, string $section): string;

    /**
     * Add attributes which got configured.
     *
     * @param Widget     $widget     Widget.
     * @param Attributes $attributes Attributes.
     */
    private function addConfiguredAttributes(Widget $widget, Attributes $attributes): void
    {
        $type = WidgetUtil::getType($widget);

        if (empty($this->widgetConfig[$type]['attributes'])) {
            return;
        }

        foreach ($this->widgetConfig[$type]['attributes'] as $attribute => $key) {
            switch (gettype($key)) {
                case 'array':
                    $attributes->setAttribute($attribute, $this->parseArrayAttributeConfig($widget, $key));
                    break;

                default:
                    $attributes->setAttribute($attribute, $widget->$key);
            }
        }
    }

    /**
     * Parse widget attributes.
     *
     * @param Widget     $widget     Widget.
     * @param Attributes $attributes Attributes.
     *
     * @throws InvalidArgumentException If an invalid attribute value or name is given.
     */
    private function parseWidgetAttributes(Widget $widget, Attributes $attributes): void
    {
        $widgetAttributes = WidgetUtil::getAttributes($widget);

        foreach ($widgetAttributes as $name => $value) {
            if (in_array($name, static::$booleanAttributes)) {
                $attributes->setAttribute($name, true);
            } elseif ($value !== '') {
                $attributes->setAttribute($name, $value);
            }
        }
    }

    /**
     * Parse array attribute config.
     *
     * @param Widget              $widget Form widget.
     * @param array<string,mixed> $config Attribute config.
     *
     * @return mixed
     */
    private function parseArrayAttributeConfig(Widget $widget, array $config)
    {
        if (! empty($config['value'])) {
            $value = $config['value'];
        } else {
            $value = $widget->{$config['key']};
        }

        if (empty($config['filters'])) {
            return $value;
        }

        return $this->evaluateAttributeFilters($value, $config['filters']);
    }

    /**
     * Evaluate attribute filters.
     *
     * @param mixed        $value   Given values.
     * @param list<string> $filters Given filters.
     *
     * @return mixed
     */
    protected function evaluateAttributeFilters($value, array $filters)
    {
        foreach ($filters as $filter) {
            switch ($filter) {
                case 'specialchars':
                    $value = StringUtil::specialchars($value);
                    break;

                default:
                    // Do nothing.
            }
        }

        return $value;
    }
}
