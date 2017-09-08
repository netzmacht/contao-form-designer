<?php

/**
 * @package    contao-form-designer
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

$GLOBALS['TL_DCA']['tl_form_field']['config']['onload_callback'][] = [
    'netzmacht.contao_form_designer.listener.dca.form_field',
    'initialize'
];
 
$GLOBALS['TL_DCA']['tl_form_field']['fields']['helpMessage'] = [
    'label'     => &$GLOBALS['TL_LANG']['tl_form_field']['helpMessage'],
    'exclude'   => true,
    'inputType' => 'text',
    'search'    => true,
    'eval'      => ['maxlength' => 255, 'tl_class' => 'long clr'],
    'sql'       => "varchar(255) NOT NULL default ''",
];
