<?php

/**
 * Contao Form Designer.
 *
 * @filesource
 */

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\Model\Form;

use Contao\FormModel;

interface FormRepository
{
    /**
     * Find a form model.
     *
     * @param int $formId Form id.
     */
    public function find(int $formId): ?FormModel;
}
