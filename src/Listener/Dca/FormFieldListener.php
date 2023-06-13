<?php

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\Listener\Dca;

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\CoreBundle\DataContainer\PaletteNotFoundException;

class FormFieldListener
{
    /**
     * Widget config.
     *
     * @var array<string,array<string,mixed>>
     */
    private array $widgetConfig;

    /** @param array<string,array<string,mixed>> $widgetConfig Widget config. */
    public function __construct(array $widgetConfig)
    {
        $this->widgetConfig = $widgetConfig;
    }

    /**
     * Initialize the palettes.
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function initialize(): void
    {
        foreach ($this->widgetConfig as $widget => $config) {
            if (! isset($GLOBALS['TL_DCA']['tl_form_field']['palettes'][$widget])) {
                continue;
            }

            $manipulator = PaletteManipulator::create()
                ->addField('controlClass', 'class')
                ->addField(
                    ['formLayout', 'controlTemplate', 'layoutTemplate'],
                    'template_legend',
                    PaletteManipulator::POSITION_APPEND,
                );

            if (! empty($config['help'])) {
                $manipulator->addField('helpMessage', 'fconfig_legend', PaletteManipulator::POSITION_APPEND);
            }

            $this->addToPalette($manipulator, $widget);

            foreach ($config['palettes'] ?? [] as $palette) {
                $this->addToPalette($manipulator, $palette);
            }
        }
    }

    private function addToPalette(PaletteManipulator $manipulator, string $palette): void
    {
        try {
            $manipulator->applyToPalette($palette, 'tl_form_field');
        } catch (PaletteNotFoundException $exception) {
            // Ignore, palette seems not to exist
        }
    }
}
