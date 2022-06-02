<?php

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\Model\Form;

use Contao\FormModel;

class ContaoFormRepository implements FormRepository
{
    public function find(int $formId): ?FormModel
    {
        return FormModel::findByPk($formId);
    }
}
