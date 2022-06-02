<?php

/**
 * Contao Form Designer.
 *
 * @filesource
 */

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\Listener\Dca\Plugin;

use Netzmacht\Contao\FormDesigner\Model\FormLayout\FormLayoutRepository;

trait FormLayoutOptionsPlugin
{
    /**
     * Form layout repository.
     *
     * @var FormLayoutRepository
     */
    protected FormLayoutRepository $formLayoutRepository;

    /**
     * Get form layout options.
     *
     * @return array<string,array<int|string, string>>
     */
    public function getFormLayoutOptions(): array
    {
        $collection = $this->formLayoutRepository->findAll();
        $options    = [];

        if ($collection) {
            foreach ($collection as $model) {
                $themeName = $model->getRelated('pid')->name . ' [ID ' . $model->pid . ']';

                $options[$themeName][$model->id] = $model->title . ' [ID ' . $model->id . ']';
            }
        }

        return $options;
    }
}
