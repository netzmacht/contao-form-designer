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

$GLOBALS['TL_DCA']['tl_form']['config']['onload_callback'][] = [
    'netzmacht.contao_form_designer.listener.dca.form',
    'preparePalette'
];

$GLOBALS['TL_DCA']['tl_form']['fields']['formLayout'] = [
    'label'            => &$GLOBALS['TL_LANG']['tl_form']['formLayout'],
    'inputType'        => 'select',
    'eval'             => [
        'tl_class'           => 'w50',
        'includeBlankOption' => true,
        'chosen'             => true,
    ],
    'options_callback' => ['netzmacht.contao_form_designer.listener.dca.form', 'getFormLayoutOptions'],
    'foreignKey'       => 'tl_form_layout.title',
    'relation'         => ['type' => 'belongsTo', 'load' => 'lazy'],
    'sql'              => "int(10) unsigned NOT NULL default '0'",
];
