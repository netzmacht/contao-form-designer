<?php

/**
 * Contao Form Designer.
 *
 * @package    contao-form-designer
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017-2018 netzmacht David Molineus. All rights reserved.
 * @license    LGPL 3.0
 * @filesource
 */

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\Listener\Dca;

use Contao\CoreBundle\Exception\PaletteNotFoundException;
use ContaoCommunityAlliance\MetaPalettes\MetaPalettes;
use Netzmacht\Contao\FormDesigner\Listener\Dca\Plugin\FormLayoutOptionsPlugin;
use Netzmacht\Contao\FormDesigner\Model\FormLayout\FormLayoutRepository;

/**
 * Class FormListener
 *
 * @package Netzmacht\Contao\FormDesigner\Listener\Dca
 */
class FormListener
{
    use FormLayoutOptionsPlugin;

    /**
     * FormListener constructor.
     *
     * @param FormLayoutRepository $formLayoutRepository Form layout repository.
     */
    public function __construct(FormLayoutRepository $formLayoutRepository)
    {
        $this->formLayoutRepository = $formLayoutRepository;
    }

    /**
     * Prepare the palette.
     *
     * @return void
     */
    public function preparePalette(): void
    {
        try {
            MetaPalettes::appendFields('tl_form', 'template', ['formLayout']);

            // @codingStandardsIgnoreStart
        } catch (PaletteNotFoundException $e) {
            // Palette does not exist. Skip it.
        }
        // @codingStandardsIgnoreEnd
    }
}
