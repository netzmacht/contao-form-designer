<?php

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\Model\Form;

use Contao\FormModel;
use Override;

final class ContaoFormRepository implements FormRepository
{
    #[Override]
    public function find(int $formId): FormModel|null
    {
        return FormModel::findByPk($formId);
    }
}
