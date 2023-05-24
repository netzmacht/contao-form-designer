<?php

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\Model\FormLayout;

use Contao\Model;

/** @property string $type */
class FormLayoutModel extends Model
{
    /**
     * Table name.
     *
     * @var string
     */
    // phpcs:ignore SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
    protected static $strTable = 'tl_form_layout';
}
