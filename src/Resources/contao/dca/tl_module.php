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

$GLOBALS['TL_DCA']['tl_module']['config']['onload_callback'][] = [
    'netzmacht.contao_form_designer.listener.dca.module',
    'initialize'
];

$GLOBALS['TL_DCA']['tl_module']['fields']['formLayout'] = [
    'label'      => &$GLOBALS['TL_LANG']['tl_module']['formLayout'],
    'inputType'  => 'select',
    'eval'       => [
        'tl_class' => 'w50',
        'includeBlankOption' => true,
        'chosen'             => true,
    ],
    'foreignKey' => 'tl_form_layout.title',
    'relation'   => ['type' => 'belongsTo', 'load' => 'lazy'],
    'sql'        => "int(10) unsigned NOT NULL default '0'",
];
