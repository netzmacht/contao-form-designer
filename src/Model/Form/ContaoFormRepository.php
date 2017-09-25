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
 * Class ContaoFormRepository.
 *
 * @package Netzmacht\Contao\FormDesigner\Model\Form
 */
class ContaoFormRepository implements FormRepository
{
    /**
     * {@inheritdoc}
     */
    public function find(int $formId): ?FormModel
    {
        return FormModel::findByPk($formId);
    }
}
