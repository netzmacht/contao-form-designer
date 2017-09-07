<?php

/**
 * @package    contao-form-designer
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

// Operations
array_insert(
    $GLOBALS['TL_DCA']['tl_theme']['list']['operations'],
    -1,
    [
        'form_layout' => [
            'href'  => 'table=tl_form_layout',
            'label' => &$GLOBALS['TL_LANG']['tl_theme']['form_layout'],
            'icon'  => 'bundles/netzmachtcontaoformdesigner/img/form.gif'
        ]
    ]
);
