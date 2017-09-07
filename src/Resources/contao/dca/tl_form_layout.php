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
        'enableVersioning' => true,
        'sql'              => [
            'keys' => [
                'id'  => 'primary',
                'pid' => 'index',
            ],
        ],
    ],
    'palettes'     => [
        '__selector__' => ['type'],
    ],
    'metapalettes' => [
        'default'                  => [
            'title' => ['title', 'type', 'default'],
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
                'href'       => 'act=paste&amp;mode=copy',
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
            'foreignKey' => 'tl_theme.title',
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
        'default'         => [
            'label'     => &$GLOBALS['TL_LANG']['tl_form_layout']['default'],
            'exclude'   => true,
            'inputType' => 'checkbox',
            'eval'      => ['tl_class' => 'w50 m12'],
            'sql'       => "char(1) NOT NULL default ''",
        ],
        'widgets'         => [
            'label'     => &$GLOBALS['TL_LANG']['tl_form_layout']['widgets'],
            'exclude'   => true,
            'inputType' => 'multiColumnWizard',
            'eval'      => [
                'tl_class'     => 'clr long',
                'columnFields' => [
                    'widget' => [
                        'label'            => &$GLOBALS['TL_LANG']['tl_form_layout']['widgets'],
                        'inputType'        => 'select',
                        'options_callback' => [
                            'netzmacht.contao_form_designer.listener.dca.form_layout',
                            'getWidgetTypes',
                        ],
                        'eval' => [
                            'style' => 'width: 20%'
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
                            'style' => 'width: 20%'
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
                            'style' => 'width: 20%'
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
                            'style' => 'width: 20%'
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
                            'style' => 'width: 20%'
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
                            'style' => 'width: 20%'
                        ]
                    ],
                ],
            ],
            'sql'       => "varchar(64) NOT NULL default ''",
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
