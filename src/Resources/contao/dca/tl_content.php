<?php

declare(strict_types=1);

use Doctrine\DBAL\Types\Types;

$GLOBALS['TL_DCA']['tl_content']['config']['onload_callback'][] = [
    'netzmacht.contao_form_designer.listener.dca.content',
    'initialize',
];

$GLOBALS['TL_DCA']['tl_content']['fields']['formLayout'] = [
    'inputType'        => 'select',
    'eval'             => [
        'tl_class'           => 'w50',
        'includeBlankOption' => true,
        'chosen'             => true,
    ],
    'options_callback' => ['netzmacht.contao_form_designer.listener.dca.content', 'getFormLayoutOptions'],
    'foreignKey'       => 'tl_form_layout.title',
    'relation'         => ['type' => 'belongsTo', 'load' => 'lazy'],
    'sql'              => ['type' => Types::INTEGER, 'unsigned' => true, 'default' => 0, 'notnull' => true],
];
