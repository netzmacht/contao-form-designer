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

namespace Netzmacht\Contao\FormDesigner\Factory;

use Netzmacht\Contao\FormDesigner\Exception\CreatingLayoutFailed;
use Netzmacht\Contao\FormDesigner\Layout\FormLayout;

/**
 * Class FormLayoutFactory.
 *
 * @package Netzmacht\Contao\FormDesigner
 */
class DelegatingFormLayoutFactory implements FormLayoutFactory
{
    /**
     * Factories map.
     *
     * @var FormLayoutFactory[]
     */
    private $factories = [];

    /**
     * FormLayoutFactory constructor.
     *
     * @param array|FormLayoutFactory[] $factories Form layout factories.
     */
    public function __construct(array $factories)
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
     * @return array
     */
    public function supportedTypes(): array
    {
        return array_reduce(
            $this->factories,
            function ($types, FormLayoutFactory $factory) {
                return array_merge($types, $factory->supportedTypes());
            },
            []
        );
    }
}
