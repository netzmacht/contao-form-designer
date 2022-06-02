<?php

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\Event;

use Contao\Widget;
use Netzmacht\Contao\FormDesigner\Layout\FormLayout;
use Symfony\Contracts\EventDispatcher\Event;

class SelectLayoutEvent extends Event
{
    public const NAME = 'netzmacht.contao_form_designer.select_layout';

    /**
     * Form widget.
     */
    private Widget $widget;

    /**
     * Form layout.
     */
    private ?FormLayout $layout = null;

    /**
     * @param Widget $widget Form element widget.
     */
    public function __construct(Widget $widget)
    {
        $this->widget = $widget;
    }

    /**
     * Get widget.
     */
    public function getWidget(): Widget
    {
        return $this->widget;
    }

    /**
     * Set a new form layout.
     *
     * @param FormLayout $formLayout Form layout.
     */
    public function setLayout(FormLayout $formLayout): void
    {
        $this->layout = $formLayout;
    }

    /**
     * Get the form layout.
     */
    public function getLayout(): ?FormLayout
    {
        return $this->layout;
    }
}
