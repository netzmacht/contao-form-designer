<?php

declare(strict_types=1);

$GLOBALS['TL_DCA']['tl_module']['config']['onload_callback'][] = [
    'netzmacht.contao_form_designer.listener.dca.module',
    'initialize',
];

$GLOBALS['TL_DCA']['tl_module']['fields']['formLayout'] = [
    'label'            => &$GLOBALS['TL_LANG']['tl_module']['formLayout'],
    'inputType'        => 'select',
    'eval'             => [
        'tl_class'           => 'w50',
        'includeBlankOption' => true,
        'chosen'             => true,
    ],
    'options_callback' => ['netzmacht.contao_form_designer.listener.dca.module', 'getFormLayoutOptions'],
    'foreignKey'       => 'tl_form_layout.title',
    'relation'         => ['type' => 'belongsTo', 'load' => 'lazy'],
    'sql'              => "int(10) unsigned NOT NULL default '0'",
];
