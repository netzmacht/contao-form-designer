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

namespace Netzmacht\Contao\FormDesigner\Listener\Dca\Plugin;

use Netzmacht\Contao\FormDesigner\Model\FormLayout\FormLayoutRepository;

/**
 * Trait FormLayoutOptionsPlugin
 *
 * @package Netzmacht\Contao\FormDesigner\Listener\Dca\Plugin
 */
trait FormLayoutOptionsPlugin
{
    /**
     * Form layout repository.
     *
     * @var FormLayoutRepository
     */
    protected $formLayoutRepository;

    /**
     * Get form layout options.
     *
     * @return array
     */
    public function getFormLayoutOptions(): array
    {
        $collection = $this->formLayoutRepository->findAll();
        $options    = [];

        foreach ($collection as $model) {
            $themeName = $model->getRelated('pid')->name . ' [ID ' . $model->pid . ']';

            $options[$themeName][$model->id] = $model->title . ' [ID ' . $model->id . ']';
        }

        return $options;
    }
}
