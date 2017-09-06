<?php

/**
 * @package    contao-form-designer
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */


namespace Netzmacht\Contao\FormDesigner\Util;

use Contao\Widget;

/**
 * Class CaptchaUtil
 *
 * @package Netzmacht\Contao\FormDesigner\Util
 * @method static getOptions(Widget $widget)
 * @method static getSum(Widget $widget)
 */
final class WidgetUtil
{
    public static function __callStatic($name, $arguments)
    {
        $widget  = array_shift($arguments);
        $closure = function () use ($name, $arguments) {
            return call_user_func_array([$this, $name], $arguments);
        };

        $closure = $closure->bindTo($widget, Widget::class);

        return $closure();
    }

}
