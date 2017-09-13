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

namespace Netzmacht\Contao\FormDesigner\Exception;

/**
 * Class CreatingLayoutFailed.
 *
 * @package Netzmacht\Contao\FormDesigner\Exception
 */
class CreatingLayoutFailed extends Exception
{
    /**
     * Create exception for an unsupported type.
     *
     * @param string $type Type.
     *
     * @return static
     */
    public static function unsupportedType($type): self
    {
        return new static(sprintf('Creating layout failed. Unsupported layout type "%s".', $type));
    }
}
