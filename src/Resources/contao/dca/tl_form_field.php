<?php

declare(strict_types=1);

$GLOBALS['TL_DCA']['tl_form_field']['config']['onload_callback'][] = [
    'netzmacht.contao_form_designer.listener.dca.form_field',
    'initialize',
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['helpMessage'] = [
    'exclude'   => true,
    'inputType' => 'text',
    'search'    => true,
    'eval'      => ['maxlength' => 255, 'tl_class' => 'long clr'],
    'sql'       => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['controlClass'] = [
    'exclude'   => true,
    'search'    => true,
    'inputType' => 'text',
    'eval'      => ['maxlength' => 255, 'tl_class' => 'w50'],
    'sql'       => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['formLayout'] = [
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

$GLOBALS['TL_DCA']['tl_form_field']['fields']['controlTemplate'] = [
    'exclude'          => true,
    'label'            => &$GLOBALS['TL_LANG']['tl_form_layout']['control'],
    'inputType'        => 'select',
    'options_callback' => [
        'netzmacht.contao_form_designer.listener.dca.form_layout',
        'getControlTemplates',
    ],
    'eval'             => [
        'includeBlankOption' => true,
        'chosen'             => true,
        'tl_class'           => 'clr w50',
    ],
    'sql'              => "varchar(255) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['layoutTemplate'] = [
    'exclude'          => true,
    'inputType'        => 'select',
    'options_callback' => [
        'netzmacht.contao_form_designer.listener.dca.form_layout',
        'getLayoutTemplates',
    ],
    'eval'             => [
        'includeBlankOption' => true,
        'chosen'             => true,
        'tl_class'           => 'w50',
    ],
    'sql'              => "varchar(255) NOT NULL default ''",
];
