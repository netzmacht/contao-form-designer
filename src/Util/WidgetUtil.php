<?php

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\Util;

use Closure;
use Contao\Widget;

use function array_key_exists;
use function array_search;
use function array_shift;
use function get_class;
use function method_exists;

/**
 * @method static getOptions(Widget $widget)
 * @method static getSum(Widget $widget)
 */
final class WidgetUtil
{
    /**
     * Call a protected method of the widget.
     *
     * @param string      $name      Name of the method.
     * @param list<mixed> $arguments Arguments. First argument has to be the widget.
     *
     * @return mixed
     */
    // phpcs:ignore SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingNativeTypeHint
    public static function __callStatic(string $name, array $arguments)
    {
        $widget = array_shift($arguments);

        /** @psalm-suppress InvalidScope */
        return static::invokeClosure(
            $widget,
            /** @return mixed */
            function () use ($name, $arguments) {
                // @codingStandardsIgnoreStart
                return call_user_func_array([$this, $name], $arguments);
                // @codingStandardsIgnoreEnd
            },
        );
    }

    /**
     * Get the attributes of an widget.
     *
     * @param Widget $widget Form widget.
     *
     * @return array<string,mixed>
     */
    public static function getAttributes(Widget $widget): array
    {
        /** @psalm-suppress InvalidScope */
        return (array) self::invokeClosure(
            $widget,
            /** @return mixed */
            function () {
                // @codingStandardsIgnoreStart
                return $this->arrAttributes;
                // @codingStandardsIgnoreEnd
            },
        );
    }

    /**
     * Get the widget tye from the form widget
     *
     * @param Widget $widget Form widget.
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     */
    public static function getType(Widget $widget): string|null
    {
        static $types = [];

        $widgetClass = get_class($widget);
        if (array_key_exists($widgetClass, $types)) {
            return $types[$widgetClass];
        }

        $found               = array_search($widgetClass, $GLOBALS['TL_FFL'] ?? [], true);
        $types[$widgetClass] = ($found ?: $widget->type);

        return $types[$widgetClass] ?: null;
    }

    /**
     * Get the hash if method getHash method exists.
     *
     * @param Widget $widget The widget.
     */
    public static function getHash(Widget $widget): string|null
    {
        /** @psalm-suppress InvalidScope */
        return self::invokeClosure(
            $widget,
            function () {
                // @codingStandardsIgnoreStart
                if (method_exists($this, 'getHash')) {
                    return $this->getHash();
                }
                // @codingStandardsIgnoreEnd

                return null;
            },
        );
    }

    /**
     * Bind a closure to the widget and invoke it.
     *
     * @param Widget  $widget  The widget.
     * @param Closure $closure The closure.
     */
    private static function invokeClosure(Widget $widget, Closure $closure): mixed
    {
        $closure = $closure->bindTo($widget, get_class($widget));
        if ($closure instanceof Closure) {
            return $closure();
        }

        return null;
    }
}
