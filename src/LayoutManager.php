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

namespace Netzmacht\Contao\FormDesigner;

use Contao\Widget;
use Netzmacht\Contao\FormDesigner\Event\SelectLayoutEvent;
use Netzmacht\Contao\FormDesigner\Layout\FormLayout;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as EventDispatcher;

/**
 * Class LayoutManager.
 *
 * @package Netzmacht\Contao\FormDesigner
 */
class LayoutManager
{
    /**
     * Event dispatcher.
     *
     * @var EventDispatcher
     */
    private $eventDispatcher;

    /**
     * Fallback form layout.
     *
     * @var FormLayout
     */
    private $fallbackLayout;

    /**
     * Contextual registered form layout.
     *
     * @var FormLayout
     */
    private $contextLayout;

    /**
     * Default form layout.
     *
     * @var FormLayout
     */
    private $defaultThemeLayout;

    /**
     * LayoutManager constructor.
     *
     * @param EventDispatcher $eventDispatcher Event dispatcher.
     * @param FormLayout      $fallbackLayout  Form layout.
     */
    public function __construct(EventDispatcher $eventDispatcher, FormLayout $fallbackLayout)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->fallbackLayout  = $fallbackLayout;
    }

    /**
     * Get the layout.
     *
     * @param Widget $widget Form widget.
     *
     * @return FormLayout
     */
    public function getLayout(Widget $widget): FormLayout
    {
        $event = new SelectLayoutEvent($widget);
        $this->eventDispatcher->dispatch($event::NAME, $event);

        if ($event->getLayout()) {
            return $event->getLayout();
        }

        if ($this->contextLayout) {
            return $this->contextLayout;
        }

        if ($this->defaultThemeLayout) {
            return $this->defaultThemeLayout;
        }

        return $this->fallbackLayout;
    }

    /**
     * Register a contextual form layout.
     *
     * @param FormLayout $formLayout Form layout.
     *
     * @return void
     */
    public function setContextLayout(FormLayout $formLayout): void
    {
        $this->contextLayout = $formLayout;
    }

    /**
     * Remove the context layout.
     *
     * @return void
     */
    public function removeContextLayout(): void
    {
        $this->contextLayout = null;
    }

    /**
     * Set default form Layout.
     *
     * @param FormLayout $layout DefaultThemeLayout.
     *
     * @return void
     */
    public function setDefaultThemeLayout(FormLayout $layout): void
    {
        $this->defaultThemeLayout = $layout;
    }

    /**
     * Check if the default form layout isset.
     *
     * @return bool
     */
    public function hasDefaultThemeLayout(): bool
    {
        return (bool) $this->defaultThemeLayout;
    }
}
