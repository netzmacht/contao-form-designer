<?php

declare(strict_types=1);

use Netzmacht\Contao\FormDesigner\Model\FormLayout\FormLayoutModel;

// Backend modules
$GLOBALS['BE_MOD']['design']['themes']['tables'][] = 'tl_form_layout';

// Models
$GLOBALS['TL_MODELS']['tl_form_layout'] = FormLayoutModel::class;

// Hooks
$GLOBALS['TL_HOOKS']['isVisibleElement'][] = [
    'netzmacht.contao_form_designer.listener.contextual_form_layout',
    'onIsVisibleElement',
];

$GLOBALS['TL_HOOKS']['getContentElement'][] = [
    'netzmacht.contao_form_designer.listener.contextual_form_layout',
    'onPostGenerateElement',
];

$GLOBALS['TL_HOOKS']['getFrontendModule'][] = [
    'netzmacht.contao_form_designer.listener.contextual_form_layout',
    'onPostGenerateElement',
];

$GLOBALS['TL_HOOKS']['getPageLayout'][] = [
    'netzmacht.contao_form_designer.listener.theme_form_layout',
    'onPageLayout',
];

$GLOBALS['TL_HOOKS']['exportTheme'][] = [
    'netzmacht.contao_form_designer.listener.theme_export',
    'onExportTheme',
];

$GLOBALS['TL_HOOKS']['extractThemeFiles'][] = [
    'netzmacht.contao_form_designer.listener.theme_import',
    'onExtractThemeFiles',
];

// Easy themes
$GLOBALS['TL_EASY_THEMES_MODULES']['form_layout'] = ['href_fragment' => 'table=tl_form_layout'];
