<?php

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\Listener\Dca;

use Contao\CoreBundle\DataContainer\PaletteNotFoundException;
use Contao\CoreBundle\Exception\PaletteNotFoundException as LegacyPaletteNotFoundException;
use ContaoCommunityAlliance\MetaPalettes\MetaPalettes;
use Netzmacht\Contao\FormDesigner\Listener\Dca\Plugin\FormLayoutOptionsPlugin;
use Netzmacht\Contao\FormDesigner\Model\FormLayout\FormLayoutRepository;

class ContentListener
{
    use FormLayoutOptionsPlugin;

    /**
     * List of supported content elements.
     *
     * @var list<string>
     */
    private $supportedElements;

    /**
     * @param FormLayoutRepository $formLayoutRepository Form layout repository.
     * @param list<string>         $supportedElements    List of supported content elements.
     */
    public function __construct(FormLayoutRepository $formLayoutRepository, array $supportedElements)
    {
        $this->supportedElements    = $supportedElements;
        $this->formLayoutRepository = $formLayoutRepository;
    }

    /**
     * Initialize.
     */
    public function initialize(): void
    {
        foreach ($this->supportedElements as $element) {
            try {
                MetaPalettes::appendFields('tl_content', $element, 'include', ['formLayout']);
            } catch (PaletteNotFoundException | LegacyPaletteNotFoundException $e) {
                // Palette does not exist. So skip it.
            }
        }
    }
}
