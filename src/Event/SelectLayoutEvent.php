<?php

/**
 * Contao Form Designer.
 *
 * @package    contao-form-designer
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @license    LGPL 3.0
 * @filesource
 */

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\Event;

use Contao\Widget;
use Netzmacht\Contao\FormDesigner\Layout\FormLayout;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class SelectLayoutEvent.
 *
 * @package Netzmacht\Contao\FormDesigner\Event
 */
class SelectLayoutEvent extends Event
{
    const NAME = 'netzmacht.contao_form_designer.select_layout';

    /**
     * Form widget.
     *
     * @var Widget
     */
    private $widget;

    /**
     * Form layout.
     *
     * @var FormLayout
     */
    private $layout;

    /**
     * SelectLayoutEvent constructor.
     *
     * @param Widget $widget Form element widget.
     */
    public function __construct(Widget $widget)
    {
        $this->widget = $widget;
    }

    /**
     * Get widget.
     *
     * @return Widget
     */
    public function getWidget(): Widget
    {
        return $this->widget;
    }

    /**
     * Set a new form layout.
     *
     * @param FormLayout $formLayout Form layout.
     *
     * @return void
     */
    public function setLayout(FormLayout $formLayout): void
    {
        $this->layout = $formLayout;
    }

    /**
     * Get the form layout.
     *
     * @return FormLayout|null
     */
    public function getLayout(): ?FormLayout
    {
        return $this->layout;
    }
}
