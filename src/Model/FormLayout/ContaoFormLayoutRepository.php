<?php

/**
 * @package    contao-form-designer
 * @author     David Molineus <david.molineus@netzmacht.de>
 * @copyright  2017 netzmacht David Molineus. All rights reserved.
 * @filesource
 *
 */

namespace Netzmacht\Contao\FormDesigner\Model\FormLayout;

/**
 * Class FormLayoutRepository.
 *
 * @package Netzmacht\Contao\FormDesigner\Model\FormLayout
 */
class ContaoFormLayoutRepository implements FormLayoutRepository
{
    /**
     * {@inheritdoc}
     */
    public function findDefaultByTheme($themeId)
    {
        return FormLayoutModel::findOneBy(['tl_form_layout.pid=?', 'tl_form_layout.default=1'], [$themeId]);
    }

    /**
     * {@inheritdoc}
     */
    public function find($layoutId)
    {
        return FormLayoutModel::findByPk($layoutId);
    }
}
