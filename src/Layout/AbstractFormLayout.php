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
}
