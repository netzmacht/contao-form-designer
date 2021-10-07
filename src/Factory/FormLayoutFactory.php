<?php

/**
 * Contao Form Designer.
 *
 * @filesource
 */

declare(strict_types=1);

namespace Netzmacht\Contao\FormDesigner\Factory;

use Netzmacht\Contao\FormDesigner\Exception\CreatingLayoutFailed;
use Netzmacht\Contao\FormDesigner\Layout\FormLayout;

interface FormLayoutFactory
{
    /**
     * Create the layout for a widget.
     *
     * @param string              $type   Given type.
     * @param array<string,mixed> $config Form layout config.
     *
     * @throws CreatingLayoutFailed When layout could not be created.
     */
    public function create(string $type, array $config): FormLayout;

    /**
     * Get the list of supported types.
     *
     * @return list<string>
     */
    public function supportedTypes(): array;
}
