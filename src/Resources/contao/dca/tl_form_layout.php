<?php

/**
 * @package    contao-form-designer
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

$GLOBALS['TL_DCA']['tl_form_layout'] = [
    'config'       => [
        'dataContainer'    => 'Table',
        'ptable'           => 'tl_theme',
        'enableVersioning' => true,
        'sql'              => [
            'keys' => [
                'id'  => 'primary',
                'pid' => 'index',
            ],
        ],
        'onload_callback' => [
            ['netzmacht.contao_form_designer.listener.dca.form_layout', 'loadStyles'],
        ],
        'onsubmit_callback' => [
            ['netzmacht.contao_form_designer.listener.dca.form_layout', 'setDefaultLayout'],
        ]
    ],
    'palettes'     => [
        '__selector__' => ['type'],
    ],
    'metapalettes' => [
        'default'                  => [
            'title' => ['title', 'type', 'defaultLayout'],
        ],
        'standard extends default' => [
            'widgets'  => ['widgets'],
            'fallback' => ['fallbackLayout', 'fallbackControl', 'fallbackLabel', 'fallbackError', 'fallbackHelp'],
        ],
    ],
    'list'         => [
        'sorting'           => [
            'mode'        => 1,
            'fields'      => ['type', 'title'],
            'panelLayout' => 'filter;search',
        ],
        'label'             => [
            'fields' => ['title', 'inColumn'],
            'format' => '%s <span style="color:#999;padding-left:3px">[%s]</span>',
            'label_callback' => ['netzmacht.contao_form_designer.listener.dca.form_layout', 'generateRowLabel'],
        ],
        'global_operations' => [
            'toggleNodes' => [
                'label'        => &$GLOBALS['TL_LANG']['MSC']['toggleAll'],
                'href'         => '&amp;ptg=all',
                'class'        => 'header_toggle',
                'showOnSelect' => true,
            ],
            'all'         => [
                'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'       => 'act=select',
                'class'      => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"',
            ],
        ],
        'operations'        => [
            'edit'   => [
                'label' => &$GLOBALS['TL_LANG']['tl_form_layout']['edit'],
                'href'  => 'act=edit',
                'icon'  => 'edit.svg',
            ],
            'copy'   => [
                'label'      => &$GLOBALS['TL_LANG']['tl_form_layout']['copy'],
                'href'       => 'act=copy',
                'icon'       => 'copy.svg',
                'attributes' => 'onclick="Backend.getScrollOffset()"',
            ],
            'delete' => [
                'label'      => &$GLOBALS['TL_LANG']['tl_form_layout']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
            ],
            'show'   => [
                'label' => &$GLOBALS['TL_LANG']['tl_form_layout']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.svg',
            ],
        ],
    ],
    'fields'       => [
        'id'              => [
            'label'  => ['ID'],
            'search' => true,
            'sql'    => "int(10) unsigned NOT NULL auto_increment",
        ],
        'pid'             => [
            'foreignKey' => 'tl_theme.name',
            'sql'        => "int(10) unsigned NOT NULL default '0'",
            'relation'   => ['type' => 'belongsTo', 'load' => 'lazy'],
        ],
        'tstamp'          => [
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],
        'title'           => [
            'label'     => &$GLOBALS['TL_LANG']['tl_form_layout']['title'],
            'exclude'   => true,
            'inputType' => 'text',
            'search'    => true,
            'eval'      => ['mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
            'sql'       => "varchar(255) NOT NULL default ''",
        ],
        'type'            => [
            'label'            => &$GLOBALS['TL_LANG']['tl_form_layout']['type'],
            'exclude'          => true,
            'filter'           => true,
            'inputType'        => 'select',
            'options_callback' => ['netzmacht.contao_form_designer.listener.dca.form_layout', 'getTypes'],
            'eval'             => [
                'tl_class'           => 'w50',
                'includeBlankOption' => true,
                'chosen'             => true,
                'submitOnChange'     => true,
            ],
            'sql'              => "varchar(32) NOT NULL default ''",
        ],
        'defaultLayout'         => [
            'label'     => &$GLOBALS['TL_LANG']['tl_form_layout']['defaultLayout'],
            'exclude'   => true,
            'inputType' => 'checkbox',
            'eval'      => ['tl_class' => 'w50'],
            'sql'       => "char(1) NOT NULL default ''",
        ],
        'widgets'         => [
            'label'     => &$GLOBALS['TL_LANG']['tl_form_layout']['widgets'],
            'exclude'   => true,
            'inputType' => 'multiColumnWizard',
            'eval'      => [
                'tl_class'     => 'clr long widgets-wizard',
                'columnFields' => [
                    'widget' => [
                        'label'            => &$GLOBALS['TL_LANG']['tl_form_layout']['widget'],
                        'inputType'        => 'select',
                        'options_callback' => [
                            'netzmacht.contao_form_designer.listener.dca.form_layout',
                            'getWidgetTypes',
                        ],
                        'eval' => [
                            'includeBlankOption' => true,
                            'chosen' => true,
                        ]
                    ],
                    'layout' => [
                        'label'            => &$GLOBALS['TL_LANG']['tl_form_layout']['layout'],
                        'inputType'        => 'select',
                        'options_callback' => [
                            'netzmacht.contao_form_designer.listener.dca.form_layout',
                            'getLayoutTemplates',
                        ],
                        'eval' => [
                            'includeBlankOption' => true,
                            'chosen' => true,
                        ]
                    ],
                    'control' => [
                        'label'            => &$GLOBALS['TL_LANG']['tl_form_layout']['control'],
                        'inputType'        => 'select',
                        'options_callback' => [
                            'netzmacht.contao_form_designer.listener.dca.form_layout',
                            'getControlTemplates',
                        ],
                        'eval' => [
                            'includeBlankOption' => true,
                            'chosen' => true,
                        ]
                    ],
                    'label' => [
                        'label'            => &$GLOBALS['TL_LANG']['tl_form_layout']['label'],
                        'inputType'        => 'select',
                        'options_callback' => [
                            'netzmacht.contao_form_designer.listener.dca.form_layout',
                            'getLabelTemplates',
                        ],
                        'eval' => [
                            'includeBlankOption' => true,
                            'chosen' => true,
                        ]
                    ],
                    'error' => [
                        'label'            => &$GLOBALS['TL_LANG']['tl_form_layout']['error'],
                        'inputType'        => 'select',
                        'options_callback' => [
                            'netzmacht.contao_form_designer.listener.dca.form_layout',
                            'getErrorTemplates',
                        ],
                        'eval' => [
                            'includeBlankOption' => true,
                            'chosen' => true,
                        ]
                    ],
                    'help' => [
                        'label'            => &$GLOBALS['TL_LANG']['tl_form_layout']['help'],
                        'inputType'        => 'select',
                        'options_callback' => [
                            'netzmacht.contao_form_designer.listener.dca.form_layout',
                            'getHelpTemplates',
                        ],
                        'eval' => [
                            'includeBlankOption' => true,
                            'chosen' => true,
                        ]
                    ],
                ],
            ],
            'sql'       => "blob NULL",
        ],
        'fallbackLayout'  => [
            'label'            => &$GLOBALS['TL_LANG']['tl_form_layout']['fallbackLayout'],
            'exclude'          => true,
            'inputType'        => 'select',
            'options_callback' => ['netzmacht.contao_form_designer.listener.dca.form_layout', 'getLayoutTemplates'],
            'eval'             => ['tl_class' => 'w50', 'includeBlankOption' => true, 'chosen' => true,],
            'sql'              => "varchar(64) NOT NULL default ''",
        ],
        'fallbackControl' => [
            'label'            => &$GLOBALS['TL_LANG']['tl_form_layout']['fallbackControl'],
            'exclude'          => true,
            'inputType'        => 'select',
            'options_callback' => ['netzmacht.contao_form_designer.listener.dca.form_layout', 'getControlTemplates'],
            'eval'             => ['tl_class' => 'w50', 'includeBlankOption' => true, 'chosen' => true,],
            'sql'              => "varchar(64) NOT NULL default ''",
        ],
        'fallbackLabel'   => [
            'label'            => &$GLOBALS['TL_LANG']['tl_form_layout']['fallbackLabel'],
            'exclude'          => true,
            'inputType'        => 'select',
            'options_callback' => ['netzmacht.contao_form_designer.listener.dca.form_layout', 'getLabelTemplates'],
            'eval'             => ['tl_class' => 'w50', 'includeBlankOption' => true, 'chosen' => true,],
            'sql'              => "varchar(64) NOT NULL default ''",
        ],
        'fallbackError'   => [
            'label'            => &$GLOBALS['TL_LANG']['tl_form_layout']['fallbackError'],
            'exclude'          => true,
            'inputType'        => 'select',
            'options_callback' => ['netzmacht.contao_form_designer.listener.dca.form_layout', 'getErrorTemplates'],
            'eval'             => ['tl_class' => 'w50', 'includeBlankOption' => true, 'chosen' => true,],
            'sql'              => "varchar(64) NOT NULL default ''",
        ],
        'fallbackHelp'    => [
            'label'            => &$GLOBALS['TL_LANG']['tl_form_layout']['fallbackHelp'],
            'exclude'          => true,
            'inputType'        => 'select',
            'options_callback' => ['netzmacht.contao_form_designer.listener.dca.form_layout', 'getHelpTemplates'],
            'eval'             => ['tl_class' => 'w50', 'includeBlankOption' => true, 'chosen' => true,],
            'sql'              => "varchar(64) NOT NULL default ''",
        ],
    ],
];
