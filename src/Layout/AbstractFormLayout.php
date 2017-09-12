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

use Contao\FrontendTemplate;
use Contao\StringUtil;
use Contao\Widget;
use Netzmacht\Html\Attributes;

/**
 * Class AbstractFormLayout.
 *
 * @package Netzmacht\Contao\FormDesigner\Layout
 */
abstract class AbstractFormLayout implements FormLayout
{
    /**
     * Widget config.
     *
     * @var array
     */
    protected $widgetConfig;

    /**
     * AbstractFormLayout constructor.
     *
     * @param array $widgetConfig Widget config.
     */
    public function __construct(array $widgetConfig)
    {
        $this->widgetConfig = $widgetConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function render(Widget $widget): string
    {
        return $this->renderBlock($widget, $this->getLayoutTemplate($widget));
    }

    /**
     * {@inheritdoc}
     */
    public function renderControl(Widget $widget): string
    {
        return $this->renderBlock($widget, $this->getControlTemplate($widget));
    }

    /**
     * {@inheritdoc}
     */
    public function renderLabel(Widget $widget): string
    {
        return $this->renderBlock($widget, $this->getLabelTemplate($widget));
    }

    /**
     * {@inheritdoc}
     */
    public function renderErrors(Widget $widget): string
    {
        return $this->renderBlock($widget, $this->getErrorTemplate($widget));
    }

    /**
     * {@inheritdoc}
     */
    public function renderHelpText(Widget $widget): string
    {
        return $this->renderBlock($widget, $this->getHelpTextTemplate($widget));
    }

    /**
     * {@inheritdoc}
     */
    public function getContainerAttributes(Widget $widget): Attributes
    {
        $attributes = new Attributes();
        $attributes
            ->addClass('widget')
            ->addClass('widget-' . $widget->type);

        if ($widget->class) {
            $attributes->addClass($widget->class);
        }

        return $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function getLabelAttributes(Widget $widget): Attributes
    {
        $attributes = new Attributes();
        $attributes->setAttribute('for', 'ctrl_' . $widget->id);

        if ($widget->class) {
            $attributes->addClass($widget->class);
        }

        return $attributes;
    }

    /**
     * @inheritDoc
     */
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
     *
     * @return string
     */
    protected function renderBlock(Widget $widget, $template): string
    {
        if (!$template) {
            return '';
        }

        $template = new FrontendTemplate($template);
        $template->setData(
            [
                'widget' => $widget,
                'layout' => $this
            ]
        );

        return $template->parse();
    }

    /**
     * Get the layout template.
     *
     * @param Widget $widget Form widget.
     *
     * @return string
     */
    protected function getLayoutTemplate(Widget $widget): string
    {
        return $this->getTemplate($widget, 'layout');
    }

    /**
     * Get the control template.
     *
     * @param Widget $widget Form widget.
     *
     * @return string
     */
    protected function getControlTemplate(Widget $widget): string
    {
        return $this->getTemplate($widget, 'control');
    }

    /**
     * Get the label template.
     *
     * @param Widget $widget Form widget.
     *
     * @return string
     */
    protected function getLabelTemplate(Widget $widget): string
    {
        return $this->getTemplate($widget, 'label');
    }

    /**
     * Get the error template.
     *
     * @param Widget $widget Form widget.
     *
     * @return string
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
        return $this->getTemplate($widget, 'help');
    }

    /**
     * Get the help text template.
     *
     * @param Widget $widget  Form widget.
     * @param string $section Form widget section.
     *
     * @return string
     */
    abstract protected function getTemplate(Widget $widget, string $section): string;

    /**
     * Add attributes which got configured.
     *
     * @param Widget     $widget     Widget.
     * @param Attributes $attributes Attributes.
     *
     * @return void
     */
    private function addConfiguredAttributes(Widget $widget, Attributes $attributes): void
    {
        if (empty($this->widgetConfig[$widget->type]['attributes'])) {
            return;
        }

        foreach ($this->widgetConfig[$widget->type]['attributes'] as $attribute => $key) {
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
     * @return void
     */
    private function parseWidgetAttributes(Widget $widget, Attributes $attributes): void
    {
        array_map(
            function ($attribute) use ($attributes) {
                $attribute = trim($attribute);

                if (!$attribute) {
                    return;
                }

                if (preg_match('/([^=]*)="([^"]*)"/', $attribute, $matches)) {
                    $attributes->setAttribute($matches[1], $matches[2]);
                } else {
                    $attributes->setAttribute($attribute, true);
                }
            },
            explode(' ', $widget->getAttributes())
        );
    }

    /**
     * Parse array attribute config.
     *
     * @param Widget $widget
     * @param array  $config
     *
     * @return mixed
     */
    private function parseArrayAttributeConfig(Widget $widget, array $config)
    {
        if (!empty($config['value'])) {
            $value = $config['value'];
        } else {
            $value = $widget->{$config['key']};
        }

        if (empty(($config['filters']))) {
            return $value;
        }

        return $this->evaluateAttributeFilters($value, $config['filters']);
    }

    /**
     * Evaluate attribute filters.
     *
     * @param mixed $value   Given values.
     * @param array $filters Given filters
     *
     * @return mixed
     */
    protected function evaluateAttributeFilters($value, $filters)
    {
        foreach ($filters as $filter) {
            switch ($filter) {
                case 'specialchars':
                    $value = StringUtil::specialchars($value);
            }
        }

        return $value;
    }
}
