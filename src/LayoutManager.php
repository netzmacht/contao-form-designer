<?php

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner;

use Contao\Widget;
use Netzmacht\Contao\FormDesigner\Event\SelectLayoutEvent;
use Netzmacht\Contao\FormDesigner\Layout\FormLayout;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as EventDispatcher;

class LayoutManager
{
    /**
     * Event dispatcher.
     */
    private EventDispatcher $eventDispatcher;

    /**
     * Fallback form layout.
     */
    private FormLayout $fallbackLayout;

    /**
     * Contextual registered form layout.
     */
    private FormLayout|null $contextLayout = null;

    /**
     * Default form layout.
     */
    private FormLayout|null $defaultThemeLayout = null;

    /**
     * @param EventDispatcher $eventDispatcher Event dispatcher.
     * @param FormLayout      $fallbackLayout  Form layout.
     */
    public function __construct(EventDispatcher $eventDispatcher, FormLayout $fallbackLayout)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->fallbackLayout  = $fallbackLayout;
    }

    /**
     * Get the default layout independent of a form widget.
     */
    public function getDefaultLayout(): FormLayout
    {
        if ($this->contextLayout) {
            return $this->contextLayout;
        }

        if ($this->defaultThemeLayout) {
            return $this->defaultThemeLayout;
        }

        return $this->fallbackLayout;
    }

    /**
     * Get the layout.
     *
     * @param Widget $widget Form widget.
     */
    public function getLayout(Widget $widget): FormLayout
    {
        $event = new SelectLayoutEvent($widget);
        $this->eventDispatcher->dispatch($event, $event::NAME);

        $layout = $event->getLayout();
        if ($layout) {
            return $layout;
        }

        return $this->getDefaultLayout();
    }

    /**
     * Register a contextual form layout.
     *
     * @param FormLayout $formLayout Form layout.
     */
    public function setContextLayout(FormLayout $formLayout): void
    {
        $this->contextLayout = $formLayout;
    }

    /**
     * Remove the context layout.
     */
    public function removeContextLayout(): void
    {
        $this->contextLayout = null;
    }

    /**
     * Set default form Layout.
     *
     * @param FormLayout $layout DefaultThemeLayout.
     */
    public function setDefaultThemeLayout(FormLayout $layout): void
    {
        $this->defaultThemeLayout = $layout;
    }

    /**
     * Check if the default form layout isset.
     */
    public function hasDefaultThemeLayout(): bool
    {
        return (bool) $this->defaultThemeLayout;
    }
}
