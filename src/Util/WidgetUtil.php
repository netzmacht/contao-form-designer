<?php

/**
 * Contao Form Designer.
 *
 * @package    contao-form-designer
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017-2018 netzmacht David Molineus. All rights reserved.
 * @license    LGPL 3.0
 * @filesource
 */

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\Util;

use Contao\Widget;

/**
 * Class CaptchaUtil.
 *
 * @package Netzmacht\Contao\FormDesigner\Util
 *
 * @method static getOptions(Widget $widget)
 * @method static getSum(Widget $widget)
 */
final class WidgetUtil
{
    /**
     * Call a protected method of the widget.
     *
     * @param string $name      Name of the method.
     * @param array  $arguments Arguments. First argument has to be the widget.
     *
     * @return mixed
     */
    public static function __callStatic($name, $arguments)
    {
        $widget = array_shift($arguments);

        return static::invokeClosure(
            $widget,
            function () use ($name, $arguments) {
                // @codingStandardsIgnoreStart
                return call_user_func_array([$this, $name], $arguments);
                // @codingStandardsIgnoreEnd
            }
        );
    }

    /**
     * Get the attributes of an widget.
     *
     * @param Widget $widget Form widget.
     *
     * @return array
     */
    public static function getAttributes(Widget $widget): array
    {
        return (array) static::invokeClosure(
            $widget,
            function () {
                // @codingStandardsIgnoreStart
                return $this->arrAttributes;
                // @codingStandardsIgnoreEnd
            }
        );
    }

    /**
     * Bind a closure to the widget and invoke it.
     *
     * @param Widget   $widget  The widget.
     * @param \Closure $closure The closre.
     *
     * @return mixed
     */
    private static function invokeClosure(Widget $widget, \Closure $closure)
    {
        $closure = $closure->bindTo($widget, get_class($widget));

        return $closure();
    }
}
