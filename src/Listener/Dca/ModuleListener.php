<?php

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\Listener\Dca;

use Contao\CoreBundle\DataContainer\PaletteNotFoundException;
use ContaoCommunityAlliance\MetaPalettes\MetaPalettes;
use Netzmacht\Contao\FormDesigner\Listener\Dca\Plugin\FormLayoutOptionsPlugin;
use Netzmacht\Contao\FormDesigner\Model\FormLayout\FormLayoutRepository;

class ModuleListener
{
    use FormLayoutOptionsPlugin;

    /**
     * List of supported modules.
     *
     * @var list<string>
     */
    private array $supportedModules;

    /**
     * @param FormLayoutRepository $formLayoutRepository Form layout repository.
     * @param list<string>         $supportedModules     Supported modules.
     */
    public function __construct(FormLayoutRepository $formLayoutRepository, array $supportedModules)
    {
        $this->supportedModules     = $supportedModules;
        $this->formLayoutRepository = $formLayoutRepository;
    }

    /**
     * Initialize.
     */
    public function initialize(): void
    {
        foreach ($this->supportedModules as $module) {
            try {
                MetaPalettes::appendFields('tl_module', $module, 'include', ['formLayout']);
            } catch (PaletteNotFoundException) {
                // Palette does not exist. Skip it.
            }
        }
    }
}
