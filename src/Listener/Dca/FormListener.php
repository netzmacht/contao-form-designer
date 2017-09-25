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
}
