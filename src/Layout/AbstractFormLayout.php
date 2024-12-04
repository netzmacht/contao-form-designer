<?php

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\Layout;

use Contao\FrontendTemplate;
use Contao\StringUtil;
use Contao\Widget;
use Netzmacht\Contao\FormDesigner\Util\WidgetUtil;
use Netzmacht\Html\Attributes;
use Netzmacht\Html\Exception\InvalidArgumentException;

use function array_key_exists;
use function gettype;
use function in_array;
use function is_string;

abstract class AbstractFormLayout implements FormLayout
{
    /**
     * Widget config.
     *
     * @var array<string,array<string,mixed>>
     */
    protected array $widgetConfig;

    /**
     * If boolean attribute.
     *
     * @var list<string>
     */
    protected static array $booleanAttributes = [
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

    /** @param array<string,array<string,mixed>> $widgetConfig Widget config. */
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
        $attributes->addClass('widget');

        $type = WidgetUtil::getType($widget);
        if ($type !== null) {
            $attributes->addClass('widget-' . $type);
        }

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
            ],
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
        if ($widget->layoutTemplate) {
            return $widget->layoutTemplate;
        }

        return $this->getTemplate($widget, 'layout');
    }

    /**
     * Get the control template.
     *
     * @param Widget $widget Form widget.
     */
    protected function getControlTemplate(Widget $widget): string
    {
        if ($widget->controlTemplate) {
            return $widget->controlTemplate;
        }

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
            $value = match(gettype($key)) {
                'array' => $this->parseArrayAttributeConfig($widget, $key),
                default => $widget->$key,
            };

            if (is_string($value)) {
                $value = StringUtil::decodeEntities($value);
            }

            $attributes->setAttribute($attribute, $value);
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
                if (is_string($value)) {
                    $value = StringUtil::decodeEntities($value);
                }

                $attributes->setAttribute($name, $value);
            }
        }
    }

    /**
     * Parse array attribute config.
     *
     * @param Widget              $widget Form widget.
     * @param array<string,mixed> $config Attribute config.
     */
    private function parseArrayAttributeConfig(Widget $widget, array $config): mixed
    {
        if (array_key_exists('value', $config)) {
            $value = $config['value'];
        } elseif (array_key_exists('key', $config)) {
            $value = $widget->{$config['key']};
        } else {
            $value = null;
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
     */
    protected function evaluateAttributeFilters(mixed $value, array $filters): mixed
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
