<?php

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\Listener\Dca;

use Contao\CoreBundle\DataContainer\PaletteNotFoundException;
use ContaoCommunityAlliance\MetaPalettes\MetaPalettes;
use Netzmacht\Contao\FormDesigner\Listener\Dca\Plugin\FormLayoutOptionsPlugin;
use Netzmacht\Contao\FormDesigner\Model\FormLayout\FormLayoutRepository;

class FormListener
{
    use FormLayoutOptionsPlugin;

    /** @param FormLayoutRepository $formLayoutRepository Form layout repository. */
    public function __construct(FormLayoutRepository $formLayoutRepository)
    {
        $this->formLayoutRepository = $formLayoutRepository;
    }

    /**
     * Prepare the palette.
     */
    public function preparePalette(): void
    {
        try {
            MetaPalettes::appendFields('tl_form', 'template', ['formLayout']);
        } catch (PaletteNotFoundException) {
            // Palette does not exist. Skip it.
        }
    }
}
