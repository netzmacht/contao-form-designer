<?php

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\Exception;

use function sprintf;

class CreatingLayoutFailed extends Exception
{
    /**
     * Create exception for an unsupported type.
     *
     * @param string $type Type.
     */
    public static function unsupportedType(string $type): self
    {
        return new self(sprintf('Creating layout failed. Unsupported layout type "%s".', $type));
    }
}
