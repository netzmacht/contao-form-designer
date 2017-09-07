<?php

/**
 * @package    contao-form-designer
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormDesigner\Factory;

use Netzmacht\Contao\FormDesigner\Exception\CreatingLayoutFailed;

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
     * @param FormLayoutFactory[] $factories
     */
    public function __construct(array $factories)
    {
        $this->factories = $factories;
    }

    /**
     * {@inheritdoc}
     */
    public function create($type, array $config)
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
    public function supportedTypes()
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
