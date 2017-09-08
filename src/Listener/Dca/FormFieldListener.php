<?php

/**
 * @package    contao-form-designer
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\Listener\Dca;

use Bit3\Contao\MetaPalettes\MetaPalettes;

/**
 * Class FormFieldListener.
 *
 * @package Netzmacht\Contao\FormDesigner\Listener\Dca
 */
class FormFieldListener
{
    /**
     * Widget config.
     *
     * @var array
     */
    private $widgetConfig;

    /**
     * FormFieldListener constructor.
     *
     * @param array $widgetConfig Widget config.
     */
    public function __construct(array $widgetConfig)
    {
        $this->widgetConfig = $widgetConfig;
    }

    /**
     * Initialize the palettes.
     *
     * @return void
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public function initialize(): void
    {
        foreach ($this->widgetConfig as $widget => $config) {
            if (empty($config['help']) || !isset($GLOBALS['TL_DCA']['tl_form_field']['palettes'][$widget])) {
                continue;
            }

            MetaPalettes::appendFields('tl_form_field', $widget, 'fconfig', ['helpMessage']);
        }
    }
}
