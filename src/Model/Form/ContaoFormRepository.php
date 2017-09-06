<?php

/**
 * @package    contao-form-designer
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormDesigner\Model\Form;

use Contao\FormModel;

/**
 * Class ContaoFormRepository
 *
 * @package Netzmacht\Contao\FormDesigner\Model\Form
 */
class ContaoFormRepository implements FormRepository
{
    public function find($formId)
    {
        return FormModel::findByPk($formId);
    }
}
