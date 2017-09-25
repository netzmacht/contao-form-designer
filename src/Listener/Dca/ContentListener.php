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

namespace Netzmacht\Contao\FormDesigner\Listener\Dca;

use Bit3\Contao\MetaPalettes\MetaPalettes;
use Netzmacht\Contao\FormDesigner\Listener\Dca\Plugin\FormLayoutOptionsPlugin;
use Netzmacht\Contao\FormDesigner\Model\FormLayout\FormLayoutRepository;

/**
 * Class ModuleListener.
 *
 * @package Netzmacht\Contao\FormDesigner\Listener\Dca
 */
class ContentListener
{
    use FormLayoutOptionsPlugin;

    /**
     * List of supported content elements.
     *
     * @var array
     */
    private $supportedElements;

    /**
     * ModuleListener constructor.
     *
     * @param FormLayoutRepository $formLayoutRepository Form layout repository.
     * @param array                $supportedElements    List of supported content elements.
     */
    public function __construct(FormLayoutRepository $formLayoutRepository, array $supportedElements)
    {
        $this->supportedElements    = $supportedElements;
        $this->formLayoutRepository = $formLayoutRepository;
    }

    /**
     * Initialize.
     *
     * @return void
     */
    public function initialize(): void
    {
        foreach ($this->supportedElements as $element) {
            MetaPalettes::appendFields('tl_content', $element, 'include', ['formLayout']);
        }
    }
}
