<?php

/**
 * Contao Form Designer.
 *
 * @filesource
 */

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\Layout;

use Contao\Widget;
use Netzmacht\Html\Attributes;

interface FormLayout
{
    /**
     * Render a widget.
     *
     * @param Widget $widget Form widget.
     */
    public function render(Widget $widget): string;

    /**
     * Get the layout template.
     *
     * @param Widget $widget Form widget.
     */
    public function renderControl(Widget $widget): string;

    /**
     * Get the layout template.
     *
     * @param Widget $widget Form widget.
     */
    public function renderLabel(Widget $widget): string;

    /**
     * Get the layout template.
     *
     * @param Widget $widget Form widget.
     */
    public function renderErrors(Widget $widget): string;

    /**
     * Render the help text.
     *
     * @param Widget $widget Form widget.
     */
    public function renderHelpText(Widget $widget): string;

    /**
     * Get container attributes.
     *
     * @param Widget $widget Form widget.
     */
    public function getContainerAttributes(Widget $widget): Attributes;

    /**
     * Get label attributes.
     *
     * @param Widget $widget Form widget.
     */
    public function getLabelAttributes(Widget $widget): Attributes;

    /**
     * Get form control attributes.
     *
     * @param Widget $widget Form widget.
     */
    public function getControlAttributes(Widget $widget): Attributes;
}
