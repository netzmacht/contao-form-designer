<?php

declare(strict_types=1);

use Contao\DC_Table;
use Doctrine\DBAL\Types\Types;

$GLOBALS['TL_DCA']['tl_form_layout'] = [
    'config'       => [
        'dataContainer'     => DC_Table::class,
        'ptable'            => 'tl_theme',
        'enableVersioning'  => true,
        'sql'               => [
            'keys' => [
                'id'  => 'primary',
                'pid' => 'index',
            ],
        ],
        'onload_callback'   => [
            ['netzmacht.contao_form_designer.listener.dca.form_layout', 'initialize'],
        ],
        'onsubmit_callback' => [
            ['netzmacht.contao_form_designer.listener.dca.form_layout', 'setDefaultLayout'],
        ],
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
            'mode'                  => 4,
            'fields'                => ['type', 'title'],
            'headerFields'          => ['name', 'author', 'tstamp'],
            'panelLayout'           => 'filter;search',
            'child_record_callback' => ['netzmacht.contao_form_designer.listener.dca.form_layout', 'generateRowLabel'],
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
                'href'       => 'act=select',
                'class'      => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"',
            ],
        ],
        'operations'        => [
            'edit'   => [
                'primary' => true,
                'href'    => 'act=edit',
                'icon'    => 'edit.svg',
            ],
            'copy'   => [
                'href'       => 'act=copy',
                'icon'       => 'copy.svg',
                'attributes' => 'onclick="Backend.getScrollOffset()"',
            ],
            'delete' => [
                'href'       => 'act=delete',
                'icon'       => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\''
                    . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? '')
                    . '\'))return false;Backend.getScrollOffset()"',
            ],
            'show'   => [
                'href'  => 'act=show',
                'icon'  => 'show.svg',
            ],
        ],
    ],
    'fields'       => [
        'id'              => [
            'label'  => ['ID'],
            'search' => true,
            'sql'    => [
                'type'          => Types::INTEGER,
                'unsigned'      => true,
                'autoincrement' => true,
                'notnull'       => true,
            ],
        ],
        'pid'             => [
            'foreignKey' => 'tl_theme.name',
            'sql'        => ['type' => Types::INTEGER, 'unsigned' => true, 'default' => 0, 'notnull' => true],
            'relation'   => ['type' => 'belongsTo', 'load' => 'lazy'],
        ],
        'tstamp'          => [
            'sql' => ['type' => Types::INTEGER, 'unsigned' => true, 'default' => 0, 'notnull' => true],
        ],
        'title'           => [
            'exclude'   => true,
            'inputType' => 'text',
            'search'    => true,
            'eval'      => ['mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
            'sql'       => ['type' => Types::STRING, 'length' => 255, 'default' => '', 'notnull' => true],
        ],
        'type'            => [
            'exclude'          => true,
            'filter'           => true,
            'inputType'        => 'select',
            'options_callback' => ['netzmacht.contao_form_designer.listener.dca.form_layout', 'getTypes'],
            'reference'        => &$GLOBALS['TL_LANG']['tl_form_layout']['types'],
            'eval'             => [
                'tl_class'           => 'w50',
                'includeBlankOption' => true,
                'chosen'             => true,
                'submitOnChange'     => true,
            ],
            'sql'              => ['type' => Types::STRING, 'length' => 32, 'default' => '', 'notnull' => true],
        ],
        'defaultLayout'   => [
            'exclude'   => true,
            'inputType' => 'checkbox',
            'eval'      => ['tl_class' => 'w50'],
            'sql'       => [
                'type'    => Types::STRING,
                'length'  => 1,
                'fixed'   => true,
                'default' => '',
                'notnull' => true,
            ],
        ],
        'widgets'         => [
            'exclude'   => true,
            'inputType' => 'group',
            'palette'   => ['widget', 'control', 'layout'],
            'fields'    => [
                'widget'  => [
                    'inputType'        => 'select',
                    'options_callback' => [
                        'netzmacht.contao_form_designer.listener.dca.form_layout',
                        'getWidgetTypes',
                    ],
                    'reference'        => &$GLOBALS['TL_LANG']['FFL'],
                    'eval'             => [
                        'includeBlankOption' => true,
                        'chosen'             => true,
                        'tl_class'           => 'w50',
                    ],
                ],
                'control' => [
                    'inputType'        => 'select',
                    'options_callback' => [
                        'netzmacht.contao_form_designer.listener.dca.form_layout',
                        'getControlTemplates',
                    ],
                    'eval'             => [
                        'includeBlankOption' => true,
                        'chosen'             => true,
                        'tl_class'           => 'w50',
                    ],
                ],
                'layout'  => [
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
                ],
            ],
            'eval'      => ['tl_class' => 'clr long'],
            'sql'       => ['type' => Types::BLOB, 'notnull' => false],
        ],
        'fallbackLayout'  => [
            'exclude'          => true,
            'inputType'        => 'select',
            'options_callback' => ['netzmacht.contao_form_designer.listener.dca.form_layout', 'getLayoutTemplates'],
            'eval'             => ['tl_class' => 'w50', 'includeBlankOption' => true, 'chosen' => true],
            'sql'              => ['type' => Types::STRING, 'length' => 64, 'default' => '', 'notnull' => true],
        ],
        'fallbackControl' => [
            'exclude'          => true,
            'inputType'        => 'select',
            'options_callback' => ['netzmacht.contao_form_designer.listener.dca.form_layout', 'getControlTemplates'],
            'eval'             => ['tl_class' => 'w50', 'includeBlankOption' => true, 'chosen' => true],
            'sql'              => ['type' => Types::STRING, 'length' => 64, 'default' => '', 'notnull' => true],
        ],
        'fallbackLabel'   => [
            'exclude'          => true,
            'inputType'        => 'select',
            'options_callback' => ['netzmacht.contao_form_designer.listener.dca.form_layout', 'getLabelTemplates'],
            'eval'             => ['tl_class' => 'w50', 'includeBlankOption' => true, 'chosen' => true],
            'sql'              => ['type' => Types::STRING, 'length' => 64, 'default' => '', 'notnull' => true],
        ],
        'fallbackError'   => [
            'exclude'          => true,
            'inputType'        => 'select',
            'options_callback' => ['netzmacht.contao_form_designer.listener.dca.form_layout', 'getErrorTemplates'],
            'eval'             => ['tl_class' => 'w50', 'includeBlankOption' => true, 'chosen' => true],
            'sql'              => ['type' => Types::STRING, 'length' => 64, 'default' => '', 'notnull' => true],
        ],
        'fallbackHelp'    => [
            'exclude'          => true,
            'inputType'        => 'select',
            'options_callback' => ['netzmacht.contao_form_designer.listener.dca.form_layout', 'getHelpTemplates'],
            'eval'             => ['tl_class' => 'w50', 'includeBlankOption' => true, 'chosen' => true],
            'sql'              => ['type' => Types::STRING, 'length' => 64, 'default' => '', 'notnull' => true],
        ],
    ],
];
