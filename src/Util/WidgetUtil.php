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
use function array_key_exists;
use function array_search;
use function get_class;
use function method_exists;

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
     * Get the widget tye from the form widget
     *
     * @param Widget $widget Form widget.
     *
     * @return string|null
     */
    public static function getType(Widget $widget): ?string
    {
        static $types = [];

        $widgetClass = get_class($widget);
        if (array_key_exists($widgetClass, $types)) {
            return $types[$widgetClass];
        }

        $found               = array_search($widgetClass, $GLOBALS['TL_FFL'] ?? [], true);
        $types[$widgetClass] = ($found ?: $widget->type);

        return ($types[$widgetClass] ?: null);
    }

    /**
     * Get the hash if method getHash method exists.
     *
     * @param Widget $widget The widget.
     *
     * @return null|string
     */
    public static function getHash(Widget $widget): ?string
    {
        return static::invokeClosure(
            $widget,
            function () {
                // @codingStandardsIgnoreStart
                if (method_exists($this, 'getHash')) {
                    return $this->getHash();
                }
                // @codingStandardsIgnoreEnd

                return null;
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
