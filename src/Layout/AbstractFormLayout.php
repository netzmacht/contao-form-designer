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
     * Render the widget.
     *
     * @param Widget $widget   Form widget.
     * @param string $template Template name.
     *
     * @return string
     */
    protected function renderBlock(Widget $widget, $template)
    {
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
}
