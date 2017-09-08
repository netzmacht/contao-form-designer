<?php

/**
 * @package    contao-form-designer
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormDesigner\Layout;

use Contao\FrontendTemplate;
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
     * {@inheritdoc}
     */
    public function render(Widget $widget)
    {
        return $this->renderBlock($widget, $this->getLayoutTemplate($widget));
    }

    /**
     * {@inheritdoc}
     */
    public function renderControl(Widget $widget)
    {
        return $this->renderBlock($widget, $this->getControlTemplate($widget));
    }

    /**
     * {@inheritdoc}
     */
    public function renderLabel(Widget $widget)
    {
        return $this->renderBlock($widget, $this->getLabelTemplate($widget));
    }

    /**
     * {@inheritdoc}
     */
    public function renderErrors(Widget $widget)
    {
        return $this->renderBlock($widget, $this->getErrorTemplate($widget));
    }

    /**
     * {@inheritdoc}
     */
    public function renderHelpText(Widget $widget)
    {
        return $this->renderBlock($widget, $this->getHelpTextTemplate($widget));
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
     * Render the widget.
     *
     * @param Widget $widget   Form widget.
     * @param string $template Template name.
     *
     * @return string
     */
    protected function renderBlock(Widget $widget, $template)
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
    abstract protected function getLayoutTemplate(Widget $widget);

    /**
     * Get the control template.
     *
     * @param Widget $widget Form widget.
     *
     * @return string
     */
    abstract protected function getControlTemplate(Widget $widget);

    /**
     * Get the label template.
     *
     * @param Widget $widget Form widget.
     *
     * @return string
     */
    abstract protected function getLabelTemplate(Widget $widget);

    /**
     * Get the error template.
     *
     * @param Widget $widget Form widget.
     *
     * @return string
     */
    abstract protected function getErrorTemplate(Widget $widget);

    /**
     * Get the help text template.
     *
     * @param Widget $widget Form widget.
     *
     * @return string
     */
    abstract protected function getHelpTextTemplate(Widget $widget);
}
