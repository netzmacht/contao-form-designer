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

use function array_merge;
use function in_array;

class DelegatingFormLayoutFactory implements FormLayoutFactory
{
    /**
     * Factories list.
     *
     * @var FormLayoutFactory[]
     */
    private $factories;

    /**
     * @param FormLayoutFactory[] $factories Form layout factories.
     */
    public function __construct(iterable $factories)
    {
        $this->factories = $factories;
    }

    /**
     * {@inheritdoc}
     *
     * @throws CreatingLayoutFailed When type is not supported.
     */
    public function create(string $type, array $config): FormLayout
    {
        foreach ($this->factories as $factory) {
            if (in_array($type, $factory->supportedTypes())) {
                return $factory->create($type, $config);
            }
        }

        throw CreatingLayoutFailed::unsupportedType($type);
    }

    /**
     * Get the list of supported types.
     *
     * @return list<string>
     */
    public function supportedTypes(): array
    {
        $types = [];

        foreach ($this->factories as $factory) {
            $types[] = $factory->supportedTypes();
        }

        return array_merge(...$types);
    }
}
