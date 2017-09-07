<?php

/**
 * @package    contao-form-designer
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormDesigner\Exception;

use Contao\Widget;

/**
 * Class NoLayoutFound exception.
 *
 * @package Netzmacht\Contao\FormDesigner\Exception
 */
class NoLayoutFound extends Exception
{
    /**
     * Generate the no layout widget.
     *
     * @param Widget          $widget   Form widget.
     * @param int             $code     Error code.
     * @param \Throwable|null $previous Previous exception.
     *
     * @return NoLayoutFound
     */
    public static function forWidget(Widget $widget, $code = 0, \Throwable $previous = null)
    {
        $message = sprintf('No layout found for form widget type "%s"', $widget->type);

        return new static($message, $code, $previous);
    }
}
