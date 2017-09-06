<?php

/**
 * @package    contao-form-designer
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

use Netzmacht\Contao\FormDesigner\Model\FormLayout\FormLayoutModel;

// Models
$GLOBALS['TL_MODELS']['tl_form_layout'] = FormLayoutModel::class;

// Hooks
$GLOBALS['TL_HOOKS']['isVisibleElement'][] = [
    'netzmacht.contao_form_designer.listener.contextual_form_layout',
    'onIsVisibleElement'
];

$GLOBALS['TL_HOOKS']['getContentElement'][] = [
    'netzmacht.contao_form_designer.listener.contextual_form_layout',
    'onPostGenerateElement'
];

$GLOBALS['TL_HOOKS']['getFrontendModule'][] = [
    'netzmacht.contao_form_designer.listener.contextual_form_layout',
    'onPostGenerateElement'
];

$GLOBALS['TL_HOOKS']['getPage'][] = [
    'netzmacht.contao_form_designer.fallback_layout',
    'onGeneratePage'
];
