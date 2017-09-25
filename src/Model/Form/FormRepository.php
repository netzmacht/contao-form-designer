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

namespace Netzmacht\Contao\FormDesigner\Model\Form;

use Contao\FormModel;

/**
 * Interface FormRepository.
 *
 * @package Netzmacht\Contao\FormDesigner\Model\Form
 */
interface FormRepository
{
    /**
     * Find a form model.
     *
     * @param int $formId Form id.
     *
     * @return FormModel|null
     */
    public function find(int $formId): ?FormModel;
}
