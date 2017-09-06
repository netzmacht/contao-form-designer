<?php

/**
 * @package    contao-form-designer
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormDesigner\Exception;

/**
 * Class CreatingLayoutFailed.
 *
 * @package Netzmacht\Contao\FormDesigner\Exception
 */
class CreatingLayoutFailed extends Exception
{
    /**
     * @param $type
     *
     * @return static
     */
    public static function unsupportedType($type)
    {
        return new static(sprintf('Creating layout failed. Unsupported layout type "%s".', $type));
    }
}
